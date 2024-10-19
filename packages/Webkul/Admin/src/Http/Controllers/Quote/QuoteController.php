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
use Webkul\Admin\Http\Controllers\Lead\LeadController;
use Webkul\Lead\Models\Lead;
use Webkul\Contact\Models\Person;

use Webkul\Quote\Repositories\QuoteRepository;
use Webkul\Quote\Models\PaymentMethod;

class QuoteController extends Controller
{
    use PDFHandler;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected QuoteRepository $quoteRepository,
        protected LeadRepository $leadRepository
    ) {
        request()->request->add(['entity_type' => 'quotes']);
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
        $lead = $this->leadRepository->find(request('id'));
        $paymentMethods = PaymentMethod::pluck('name', 'id'); // Obtenha todos os métodos de pagamento

        return view('admin::quotes.create', compact('lead', 'paymentMethods'));
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

        //Objeto Lead(Ordem)
        $data_lead = array();
        $data_lead['entity_type'] = 'leads';
        $data_lead['lead_type_id'] = '1';
        $data_lead['lead_pipeline_id'] = '1';
        $data_lead['lead_pipeline_stage_id'] = '1';
        $data_lead['lead_source_id'] = '1';
        $data_lead['user_id'] = request('user_id');
        $data_lead['status'] = '1';
        $data_lead['raca'] = request('raca');
        $data_lead['description'] = request('description');
        $data_lead['person'] = array(
            'name' => $person_request['name'],
            'email' => [0 => ['value' => $person_request['emails'][0]['value']]],
            'contact_numbers' => [0 => ['value' => $person_request['contact_numbers'][0]['value']]],
        );

        //Salvando Pessoa da Venda e Ordem
        $person = Person::create($data_lead['person']);
        $data_lead['person']['id'] = $person->id;
        $data_lead['person_id'] = $person->id;
        $data_lead['lead_value'] = request('grand_total');

        //Salvando Ordem
        $lead = Lead::create($data_lead);

        Event::dispatch('quote.create.before');

        $data_quote = $request->all();
        $data_quote['person']['id'] = $person->id;
        $data_quote['person_id'] = $person->id;

        $quote = $this->quoteRepository->create($data_quote);
        if ($lead->id) {
            $lead = $this->leadRepository->find($lead->id);

            $lead->quotes()->attach($quote->id);
        }

        Event::dispatch('quote.create.after', $quote);

        session()->flash('success', trans('admin::app.quotes.index.create-success'));

        return redirect()->route('admin.quotes.index');
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

        // Atualizar o lead com os novos dados
        $data_lead = [
            'entity_type' => 'leads',
            'lead_type_id' => '1',
            'lead_pipeline_id' => '1',
            'lead_pipeline_stage_id' => '1',
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
        $this->quoteRepository->findOrFail($id);

        try {
            Event::dispatch('quote.delete.before', $id);

            $this->quoteRepository->delete($id);

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

                $this->quoteRepository->delete($quotes->id);

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
