<?php

namespace Webkul\Admin\Http\Controllers\Quote;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Prettus\Repository\Criteria\RequestCriteria;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webkul\Admin\DataGrids\Quote\QuoteDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\AttributeForm;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Admin\Http\Resources\QuoteResource;
use Webkul\Core\Traits\PDFHandler;
use Webkul\Lead\Repositories\LeadRepository;
use Webkul\Contact\Repositories\PersonRepository;
use Webkul\Remarketing\Repositories\RemarketingRepository;
use Webkul\Lead\Models\Lead;
use Illuminate\Support\Facades\Log;
use Webkul\Quote\Repositories\QuoteRepository;
use Webkul\Quote\Models\PaymentMethod;
use Webkul\Quote\Services\ZarponService;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    use PDFHandler;

    protected $zarponService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected QuoteRepository $quoteRepository,
        protected LeadRepository $leadRepository,
        protected PersonRepository $personRepository,
        protected RemarketingRepository $remarketingRepository,
        ZarponService $zarponService
    ) {
        request()->request->add(['entity_type' => 'quotes']);

        $this->zarponService = $zarponService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(QuoteDataGrid::class)->process();
        }

        return view('admin::quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $remarketing = null;
        if( key_exists('remarketing_id', request()->all()) == true){
            $remarketing = (object) [
                'person'    => request()->all()['person'],
                'product_id'   => request()->all()['product_id'],
                'quantity'     => request()->all()['quantity'],
                'price'        => request()->all()['price'],
                'address'      => request()->all()['address'],
                'city'         => request()->all()['city'],
                'zipcode'      => request()->all()['zipcode'],
                'emails'       => [['value' => request()->all()['email'] ?? '']],
                'phone_number' => [['value' => request()->all()['phone_number'] ?? '']],
                'remarketing_id' => request()->all()['remarketing_id'],
            ];
        }


        $lead = $this->leadRepository->find(request('id'));
        $paymentMethods = PaymentMethod::pluck('name', 'id'); // Obtenha todos os métodos de pagamento

        return view('admin::quotes.create', compact('lead', 'paymentMethods', 'remarketing'));
    }

    public function getPaymentMethods()
    {
        $paymentMethods = PaymentMethod::select('id', 'name')->get();

        return response()->json($paymentMethods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeForm $request): RedirectResponse
    {

        //Pessoa da Requisição
        $person_request = request('person');
        try{

            // Verificação na Blacklist pelo Nome da Pessoa
            $isBlacklistedByName = DB::table('black_list')
            ->join('persons', 'black_list.person_id', '=', 'persons.id')
            ->where('persons.name', $person_request['name'])
            ->exists();

            // Verificação na Blacklist pelo Endereço
            $shippingAddress = $request->get('shipping_address');
            $addressString = implode(' ', array_filter([
                $shippingAddress['address'] ?? '',
                $shippingAddress['city'] ?? '',
                $shippingAddress['state'] ?? '',
                $shippingAddress['postcode'] ?? '',
                $shippingAddress['country'] ?? '',
            ]));

            $isBlacklistedByAddress = DB::table('black_list')
                ->join('leads', 'black_list.lead_id', '=', 'leads.id')
                ->join('lead_quotes', 'leads.id', '=', 'lead_quotes.lead_id')
                ->join('quotes', 'lead_quotes.quote_id', '=', 'quotes.id')
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(quotes.shipping_address, '$.address')) LIKE ?", ['%' . $shippingAddress['address'] . '%'])
                ->exists();

            // Se encontrado na blacklist, retorna erro
            if ($isBlacklistedByName || $isBlacklistedByAddress) {
                session()->flash('error', trans('admin::app.blacklist.blacklist-warning'));

                return redirect()->back()->withInput();
            }

            //Objeto Lead(Ordem)
            $data_lead = array();
            $data_lead['entity_type'] = 'leads';
            $data_lead['lead_type_id'] = '1';
            $data_lead['lead_pipeline_id'] = '1';
            $data_lead['lead_pipeline_stage_id'] = '1';
            $data_lead['lead_source_id'] = '1';
            $data_lead['user_id'] = request('user_id');
            $data_lead['status'] = '1';
            $data_lead['raca'] = (request('raca') == true) ? true : false;
            $data_lead['description'] = request('description');
            $data_lead['person'] = array(
                'entity_type' => '',
                'name' => $person_request['name'],
                'contact_numbers' => [0 => ['value' => $person_request['contact_numbers'][0]['value']]],
                'emails' => [0 => ['value' => $person_request['emails'][0]['value']]],
            );

            $person = $this->personRepository->create($data_lead['person']);

            $data_lead['person']['id'] = $person->id;
            $data_lead['person_id'] = $person->id;
            $data_lead['lead_value'] = request('grand_total');

            $lead = Lead::create($data_lead);

            $data_quote = $request->all();
            $data_quote['person']['id'] = $person->id;
            $data_quote['person_id'] = $person->id;

            $quote = $this->quoteRepository->create($data_quote);
            if ($lead->id) {
                $lead = $this->leadRepository->find($lead->id);

                $lead->quotes()->attach($quote->id);
            }

            if($request->get('remarketing_id')){
                $remarketing = $this->remarketingRepository->find($request->get('remarketing_id'));
                if ($remarketing) {
                    $remarketing->update([
                        'lead_id'  => $lead->id,
                        'quote_id' => $quote->id,
                    ]);
                }
            }

            $stage = $lead->pipeline->stages()
            ->where('id',$data_lead['lead_pipeline_stage_id'])
            ->firstOrFail();

            if($stage->email_template_id){
                Event::dispatch('quote.post_create.actions', ['lead' => $lead, 'email_id' => $stage->email_template_id]);
            }

            if($person->contact_numbers){
                $nome = $person->name;
                $numero = $person->contact_numbers[0]['value'];
                $id = $lead->id;
                if(request('raca') == true){
                    $isEspano = request('raca');
                }else{
                    $isEspano = false;
                }
                // Envio dos dados ao Zárpon
                $this->zarponService->sendSaudacoes($nome, $numero, $id, $isEspano);
            }

            Event::dispatch('quote.create.after', $quote);

            session()->flash('success', trans('admin::app.quotes.index.create-success'));
            return redirect()->route('admin.quotes.index');
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.quotes.index.delete-failed'),
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $quote = $this->quoteRepository->findOrFail($id);
        // Acessa a pessoa associada à quote
        $person = $quote->person;

        //Métodos de Pagamento
        $paymentMethods = PaymentMethod::pluck('name', 'id'); // Obtenha todos os métodos de pagamento

        if ($person) {
            // Verificar se os valores de contact_numbers e emails não são nulos e extrair o valor correto
            $person->contact_numbers = is_array($person->contact_numbers) ? $person->contact_numbers : json_decode($person->contact_numbers, true);
            $person->emails = is_array($person->emails) ? $person->emails : json_decode($person->emails, true);
            $person->raca = is_array( $quote->raca) ?  $quote->raca : json_decode($quote->raca, true);

        }
        // Acessa o método de pagamento associado à quote
        $paymentMethod = $quote->payment_method_id;

        return view('admin::quotes.edit', compact('quote', 'person', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeForm $request, int $id): RedirectResponse
    {
        // Pessoa da Requisição
        $person_request = $request->input('person');

        // Encontrar a quote existente
        $quote = $this->quoteRepository->findOrFail($id);

        // Obter o lead relacionado à quote
        $lead = $quote->leads()->first();

        // Atualizar os dados da pessoa
        $person = $lead->person;

        $person->update([
            'name' => $person_request['name'],
            'emails' => [0 => ['value' => $person_request['emails'][0]['value']]],
            'contact_numbers' => [0 => ['value' => $person_request['contact_numbers'][0]['value']]],
        ]);

        $data_lead = [
            'entity_type' => 'leads',
            'lead_type_id' => '1',
            'lead_pipeline_id' => '1',
            'lead_source_id' => '1',
            'user_id' => $request->input('user_id'),
            'raca' => $request->input('raca'),
            'description' => $request->input('description'),
            'person_id' => $person->id,
            'lead_value' => $request->input('grand_total'),
        ];

        // Atualizando o lead existente
        $lead->update($data_lead);

        // Evento antes da atualização da quote
        Event::dispatch('quote.update.before', $id);

        // Atualizar a quote
        $data_quote = $request->all();
        $data_quote['person_id'] = $person->id;
        $this->quoteRepository->update($data_quote, $id);

        // Desanexar e anexar novamente o lead à quote
        $quote->leads()->sync([$lead->id]);

        // Evento após a atualização da quote
        Event::dispatch('quote.update.after', $quote);

        session()->flash('success', trans('admin::app.quotes.index.update-success'));

        return redirect()->route('admin.quotes.index');
    }

    /**
     * Search the quotes.
     */
    public function search(): AnonymousResourceCollection
    {
        $quotes = $this->quoteRepository
            ->pushCriteria(app(RequestCriteria::class))
            ->all();

        return QuoteResource::collection($quotes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $quote = $this->quoteRepository->findOrFail($id);

        try {
            Event::dispatch('quote.delete.before', $id);

            $leads = $quote->leads;

            $this->quoteRepository->delete($id);

            foreach ($leads as $lead) {
                $lead->delete();
            }

            Event::dispatch('quote.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.quotes.index.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.quotes.index.delete-failed'),
            ], 400);
        }
    }

    /**
     * Mass Delete the specified resources.
     */
    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $quotes = $this->quoteRepository->findWhereIn('id', $massDestroyRequest->input('indices'));

        try {
            foreach ($quotes as $quotes) {
                Event::dispatch('quote.delete.before', $quotes->id);

                $leads = $quotes->leads;

                $this->quoteRepository->delete($quotes->id);

                foreach ($leads as $lead) {
                    $lead->delete();
                }

                Event::dispatch('quote.delete.after', $quotes->id);
            }

            return response()->json([
                'message' => trans('admin::app.quotes.index.delete-success'),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.quotes.index.delete-failed'),
            ], 400);
        }
    }

    /**
     * Print and download the for the specified resource.
     */
    public function print($id): Response|StreamedResponse
    {
        $quote = $this->quoteRepository->findOrFail($id);

        return $this->downloadPDF(
            view('admin::quotes.pdf', compact('quote'))->render(),
            'Quote_'.$quote->subject.'_'.$quote->created_at->format('d-m-Y')
        );
    }
}
