<?php

namespace Webkul\Admin\Http\Controllers\Lead;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Webkul\Core\Traits\PDFHandler;
use Illuminate\Support\Facades\DB;

use Prettus\Repository\Criteria\RequestCriteria;
use Webkul\Admin\DataGrids\Lead\LeadDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\LeadForm;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Admin\Http\Requests\MassUpdateRequest;
use Webkul\Admin\Http\Resources\LeadResource;
use Webkul\Admin\Http\Resources\StageResource;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Contact\Repositories\PersonRepository;
use Webkul\Remarketing\Repositories\RemarketingRepository;
use Webkul\DataGrid\Enums\DateRangeOptionEnum;
use Webkul\Lead\Repositories\LeadRepository;
use Webkul\Lead\Repositories\PipelineRepository;
use Webkul\Lead\Repositories\ProductRepository;
use Webkul\Lead\Repositories\SourceRepository;
use Webkul\Lead\Repositories\StageRepository;
use Webkul\Lead\Repositories\TypeRepository;
use Webkul\Lead\Models\Lead;
use Webkul\Tag\Repositories\TagRepository;
use Webkul\User\Repositories\UserRepository;
use Webkul\Quote\Models\QuoteProxy;
use Webkul\Lead\Enums\LeadStages;
use Webkul\User\Models\User;
use Webkul\Blacklist\Models\Blacklist;
use Webkul\Quote\Services\ZarponService;
use Webkul\Admin\Constants\Stages;

class LeadController extends Controller
{
    use PDFHandler;
    protected $zarponService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected UserRepository $userRepository,
        protected AttributeRepository $attributeRepository,
        protected SourceRepository $sourceRepository,
        protected TypeRepository $typeRepository,
        protected PipelineRepository $pipelineRepository,
        protected StageRepository $stageRepository,
        protected LeadRepository $leadRepository,
        protected ProductRepository $productRepository,
        protected PersonRepository $personRepository,
        protected RemarketingRepository $remarketingRepository,
        ZarponService $zarponService
    ) {
        request()->request->add(['entity_type' => 'leads']);

        $this->zarponService = $zarponService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(LeadDataGrid::class)->process();
        }

        if (request('pipeline_id')) {
            $pipeline = $this->pipelineRepository->find(request('pipeline_id'));
        } else {
            $pipeline = $this->pipelineRepository->getDefaultPipeline();
        }

        $stagesConstants = [
            'STAGE_FOLLOWUP_ID' => LeadStages::STAGE_FOLLOWUP_ID,
            'STAGE_NEW_ID' => LeadStages::STAGE_NEW_ID,
            'STAGE_WOW_ID' => LeadStages::STAGE_WOW_ID,
            'STAGE_LOST_ID'=> LeadStages::STAGE_LOST_ID,
        ];

        return view('admin::leads.index', [
            'pipeline' => $pipeline,
            'columns'  => $this->getKanbanColumns(),
            'stages'   => $stagesConstants,
        ]);
    }

    /**
     * Returns a listing of the resource.
     */
    public function get(): JsonResponse
    {
        if (request()->query('pipeline_id')) {
            $pipeline = $this->pipelineRepository->find(request()->query('pipeline_id'));
        } else {
            $pipeline = $this->pipelineRepository->getDefaultPipeline();
        }

        if ($stageId = request()->query('pipeline_stage_id')) {
            $stages = $pipeline->stages->where('id', request()->query('pipeline_stage_id'));
        } else {
            $stages = $pipeline->stages;
        }

        foreach ($stages as $stage) {
            /**
             * We have to create a new instance of the lead repository every time, which is
             * why we're not using the injected one.
             */
            $query = app(LeadRepository::class)
                ->pushCriteria(app(RequestCriteria::class))
                ->where([
                    'lead_pipeline_id'       => $pipeline->id,
                    'lead_pipeline_stage_id' => $stage->id,
                ]);

            if ($userIds = bouncer()->getAuthorizedUserIds()) {
                $query->whereIn('leads.user_id', $userIds);
            }

            $stage->lead_value = (clone $query)->sum('lead_value');

            $data[$stage->id] = (new StageResource($stage))->jsonSerialize();

            // Executamos o `with` e paginamos os resultados
            $leads = $query->with([
                'tags',
                'type',
                'source',
                'user',
                'person',
                'person.organization',
                'pipeline',
                'pipeline.stages',
                'stage',
                'attribute_values',
            ])->paginate(10);

            // Processando os leads manualmente e coletando os quotes, sem converter para array
            foreach ($leads as $lead) {
                // Carrega os quotes com os produtos associados aos quote_items
                $leadQuotes = QuoteProxy::with('items.product', 'paymentMethod')->whereHas('leads', function ($query) use ($lead) {
                    $query->where('lead_id', $lead->id);
                })->get();

                $lead->quotes = $leadQuotes; // Adicionando os quotes diretamente ao objeto do lead
            }

            // Adicionando o resultado do `with` nos dados
            $data[$stage->id]['leads'] = [
                'data' => LeadResource::collection($leads),
                'meta' => [
                    'current_page' => $leads->currentPage(),
                    'from'         => $leads->firstItem(),
                    'last_page'    => $leads->lastPage(),
                    'per_page'     => $leads->perPage(),
                    'to'           => $leads->lastItem(),
                    'total'        => $leads->total(),
                ],
            ];
        }

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin::leads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadForm $request): RedirectResponse
    {
        Event::dispatch('lead.create.before');

        $data = $request->all();

        $data['status'] = 1;

        if (request()->input('lead_pipeline_stage_id')) {
            $stage = $this->stageRepository->findOrFail($data['lead_pipeline_stage_id']);

            $data['lead_pipeline_id'] = $stage->lead_pipeline_id;
        } else {
            $pipeline = $this->pipelineRepository->getDefaultPipeline();

            $stage = $pipeline->stages()->first();

            $data['lead_pipeline_id'] = $pipeline->id;

            $data['lead_pipeline_stage_id'] = $stage->id;
        }

        if (in_array($stage->code, ['won', 'lost'])) {
            $data['closed_at'] = Carbon::now();
        }

        $data['person']['organization_id'] = empty($data['person']['organization_id']) ? null : $data['person']['organization_id'];

        $lead = $this->leadRepository->create($data);

        Event::dispatch('lead.create.after', $lead);

        session()->flash('success', trans('admin::app.leads.create-success'));

        return redirect()->route('admin.leads.index', $data['lead_pipeline_id']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $lead = $this->leadRepository->findOrFail($id);

        return view('admin::leads.edit', compact('lead'));
    }

    /**
     * Display a resource.
     */
    public function view(int $id): View
    {
        $lead = $this->leadRepository->findOrFail($id);
        $status = $this->getStatus();

        if (
            $userIds = bouncer()->getAuthorizedUserIds()
            && ! in_array($lead->user_id, $userIds)
        ) {
            return redirect()->route('admin.leads.index');
        }

        return view('admin::leads.view', compact('lead', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadForm $request, int $id): RedirectResponse|JsonResponse
    {
        Event::dispatch('lead.update.before', $id);

        $data = $request->all();

        if (isset($data['lead_pipeline_stage_id'])) {
            $stage = $this->stageRepository->findOrFail($data['lead_pipeline_stage_id']);

            $data['lead_pipeline_id'] = $stage->lead_pipeline_id;
        } else {
            $pipeline = $this->pipelineRepository->getDefaultPipeline();

            $stage = $pipeline->stages()->first();

            $data['lead_pipeline_id'] = $pipeline->id;

            $data['lead_pipeline_stage_id'] = $stage->id;
        }

        $data['person']['organization_id'] = empty($data['person']['organization_id']) ? null : $data['person']['organization_id'];

        $lead = $this->leadRepository->update($data, $id);

        Event::dispatch('lead.update.after', $lead);

        if (request()->ajax()) {
            return response()->json([
                'message' => trans('admin::app.leads.update-success'),
            ]);
        }

        session()->flash('success', trans('admin::app.leads.update-success'));

        if (request()->has('closed_at')) {
            return redirect()->back();
        } else {
            return redirect()->route('admin.leads.index', $data['lead_pipeline_id']);
        }
    }

    /**
     * Update the lead attributes.
     */
    public function updateAttributes(int $id)
    {
        $data = request()->all();
        $uspsBaseUrl = 'https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=';

        // Verifica se o campo tracking_link está presente e ajusta o link com o valor base do USPS
        if (isset($data['tracking_link'])) {
            // Se for um número de rastreamento válido, constrói o link completo
            $data['tracking_link'] = $uspsBaseUrl . $data['tracking_link'];
        }

        $attributes = $this->attributeRepository->findWhere([
            'entity_type' => 'leads',
            ['code', 'IN', ['lead_value', 'created_at', 'tracking_link']],
        ]);

        Event::dispatch('lead.update.before', $id);

        $lead = $this->leadRepository->update($data, $id, $attributes);

        Event::dispatch('lead.update.after', $lead);

        return response()->json([
            'message' => trans('admin::app.leads.update-success'),
        ]);
    }

    /**
     * Update the lead stage.
     */
    public function updateStage(int $id)
    {

        $this->validate(request(), [
            'lead_pipeline_stage_id' => 'required',
        ]);

        $lead = $this->leadRepository->findOrFail($id);

        $stage = $lead->pipeline->stages()
            ->where('id', request()->input('lead_pipeline_stage_id'))
            ->firstOrFail();

        Event::dispatch('lead.update.before', $id);

        $lead = $this->leadRepository->update(
            [
                'entity_type'            => 'leads',
                'lead_pipeline_stage_id' => $stage->id,
            ],
            $id,
            ['lead_pipeline_stage_id']
        );


        try {
            $emailTemplateId = $stage->email_template_id;

            //Se O stage de destino estiver contido no array
            if(in_array($stage->id, [LeadStages::STAGE_FOLLOWUP_ID])  ){
                if($emailTemplateId){
                    //Aciona Evento para enviar email do estágio ao interessado da compra
                    Event::dispatch('lead.stage.transition.actions', ['lead' => $lead, 'email_id' => $emailTemplateId]);
                }
            }

            //Se O stage de destino estiver contido no array
            if(in_array($stage->id, [LeadStages::STAGE_PROSPECT_ID])){
                if($emailTemplateId){
                    Event::dispatch('lead.stage.transition.actions', ['lead' => $lead, 'email_id' => $emailTemplateId]);
                }

                $person = $this->personRepository->findOrFail($lead->person_id);

                if($person->contact_numbers){
                    $nome = $person->name;
                    $numero = $person->contact_numbers[0]['value'];

                    $this->zarponService->stopFunnelForLead($numero);
                }
            }

        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.quotes.index.sendmail-failed'),
            ], 400);
        }

        Event::dispatch('lead.update.after', $lead);

        return response()->json([
            'message' => trans('admin::app.leads.update-success'),
        ]);
    }

    /**
     * Search person results.
     */
    public function search(): AnonymousResourceCollection
    {
        if ($userIds = bouncer()->getAuthorizedUserIds()) {
            $results = $this->leadRepository
                ->pushCriteria(app(RequestCriteria::class))
                ->findWhereIn('user_id', $userIds);
        } else {
            $results = $this->leadRepository
                ->pushCriteria(app(RequestCriteria::class))
                ->all();
        }

        return LeadResource::collection($results);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $lead = $this->leadRepository->findOrFail($id);

        try {
            Event::dispatch('lead.delete.before', $id);
            // Verifica se há uma relação com a `quote`
            if ($lead->quotes()->exists()) {
                // Itera sobre as quotes vinculadas e as exclui
                foreach ($lead->quotes as $quote) {
                    $quote->delete();
                }
            }

            $this->leadRepository->delete($id);

            Event::dispatch('lead.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.leads.destroy-success'),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.leads.destroy-failed'),
            ], 400);
        }
    }

    /**
     * Mass Update the specified resources.
     */
    public function massUpdate(MassUpdateRequest $massUpdateRequest): JsonResponse
    {
        $leads = $this->leadRepository->findWhereIn('id', $massUpdateRequest->input('indices'));

        try {
            foreach ($leads as $lead) {
                Event::dispatch('lead.update.before', $lead->id);

                $this->leadRepository->update(
                    ['lead_pipeline_stage_id' => $massUpdateRequest->input('value')],
                    $lead->id,
                    ['lead_pipeline_stage_id']
                );

                Event::dispatch('lead.update.before', $lead->id);
            }

            return response()->json([
                'message' => trans('admin::app.leads.update-success'),
            ]);
        } catch (\Exception $th) {
            return response()->json([
                'message' => trans('admin::app.leads.destroy-failed'),
            ], 400);
        }
    }

    /**
     * Mass Delete the specified resources.
     */
    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $leads = $this->leadRepository->findWhereIn('id', $massDestroyRequest->input('indices'));

        try {
            foreach ($leads as $lead) {
                Event::dispatch('lead.delete.before', $lead->id);

                $this->leadRepository->delete($lead->id);

                Event::dispatch('lead.delete.after', $lead->id);
            }

            return response()->json([
                'message' => trans('admin::app.leads.destroy-success'),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.leads.destroy-failed'),
            ]);
        }
    }

    /**
     * Attach product to lead.
     */
    public function addProduct(int $leadId): JsonResponse
    {
        $product = $this->productRepository->updateOrCreate(
            [
                'lead_id'    => $leadId,
                'product_id' => request()->input('product_id'),
            ],
            array_merge(
                request()->all(),
                [
                    'lead_id' => $leadId,
                    'amount'  => request()->input('price') * request()->input('quantity'),
                ],
            )
        );

        return response()->json([
            'data'    => $product,
            'message' => trans('admin::app.leads.update-success'),
        ]);
    }

    /**
     * Remove product attached to lead.
     */
    public function removeProduct(int $id): JsonResponse
    {
        try {
            Event::dispatch('lead.product.delete.before', $id);

            $this->productRepository->deleteWhere([
                'lead_id'    => $id,
                'product_id' => request()->input('product_id'),
            ]);

            Event::dispatch('lead.product.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.leads.destroy-success'),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.leads.destroy-failed'),
            ]);
        }
    }

    /**
     * Kanban lookup.
     */
    public function kanbanLookup()
    {
        $params = $this->validate(request(), [
            'column'      => ['required'],
            'search'      => ['required', 'min:2'],
        ]);

        /**
         * Finding the first column from the collection.
         */
        $column = collect($this->getKanbanColumns())->where('index', $params['column'])->firstOrFail();

        /**
         * Fetching on the basis of column options.
         */
        return app($column['filterable_options']['repository'])
            ->select([$column['filterable_options']['column']['label'].' as label', $column['filterable_options']['column']['value'].' as value'])
            ->where($column['filterable_options']['column']['label'], 'LIKE', '%'.$params['search'].'%')
            ->get()
            ->map
            ->only('label', 'value');
    }

    public function getStatus()
    {
        $status = $this->leadRepository->getStatusQuery();

        return $status;
    }

    /***
     * Salva um link de Rastreio no Objeto Lead
     */
    public function saveTrackingLink(Request $request)
    {
        $data = $request->all();
        $id = $data['lead_id'];
        $default_path = 'https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=';

        $lead = $this->leadRepository->findOrFail($id);

        Event::dispatch('lead.update.before', $lead->id);

        // Valida e atualiza o link de rastreamento
        $request->validate([
            'tracking_link' => 'required'
        ]);

        // Limpa espaços e caracteres especiais do código de rastreamento
        $tracking_code = preg_replace('/\s+/', '', $data['tracking_link']);
        $lead->tracking_link = $default_path . $tracking_code;

        $lead->save();
        $lead = $this->leadRepository->findOrFail($id);

        //Event::dispatch('lead.update.after', $lead);

        return response()->json([
            'message' => 'Link de rastreamento atualizado com sucesso!',
        ], 200);
    }

    public function saveObservacao(Request $request)
    {
        // Validação dos dados do formulário
        $validated = $request->validate([
            'status_id' => 'required|integer',
            'comment' => 'required|string',
            'lead_id' => 'required|integer',
            'payment_date' => 'required|date'
        ]);

        // Busca o lead correspondente
        $lead = $this->leadRepository->find($request->input('lead_id'));

        // Verifica se o lead foi encontrado
        if (!$lead) {
            return response()->json(['error' => 'Lead não encontrado.'], 404);  // Retorna erro 404 se o lead não for encontrado
        }
        // Salva o comentário diretamente no lead (caso tenha um campo 'comment' no banco de dados)
        $lead->billing_observation = $validated['comment'];
        $lead->billing_status_id = $validated['status_id'];
        $lead->payment_date = $validated['payment_date'];

        // Atualiza o pipeline se o status de faturamento for 1
        if ($validated['status_id'] == 1) {
            $pipeline_stage_pago = Stages::PAGO;
            // Configura o `lead_pipeline_id` para 4 quando o `billing_status_id` for 1
            $lead->lead_pipeline_stage_id = $pipeline_stage_pago;
        }

        // Dispara o evento antes da atualização
        Event::dispatch('lead.update.before', $lead->id);

        // Salva as alterações no lead
        $lead->save();

        // Dispara o evento após a atualização
        Event::dispatch('lead.update.after', $lead);

        // Retorna uma resposta ou redireciona
        return redirect()->route('admin.leads.view', $lead->id)
                            ->with('success', 'Observação salva com sucesso!');
    }

    /**
     * Print and download the for the specified resource.
     */
    public function print($id): Response|StreamedResponse
    {
        try {
            $lead = $this->leadRepository->findOrFail($id);
            $quote = null;
            $remarketing = null;

            if ($lead->quotes()->first()) {
                $quote = $lead->quotes()->with(['items.product'])->first();
            }

            if ($quote) {
                $remarketing = $this->remarketingRepository
                    ->where('quote_id', $quote->id)
                    ->first();
            }

            if ($quote->raca == 1) {
                App::setLocale('es');
            } else {
                App::setLocale('pt');
            }

            return $this->downloadPDF(
                view('admin::quotes.pdf', compact('quote', 'remarketing'))->render(),
                'Quote_'.$quote->id.'_'.$quote->created_at->format('d-m-Y')
            );

        } catch (\Exception $th) {
            return response()->make('Falha ao tentar imprimir recibo: ' . $th->getMessage(), 500);
        }
    }

    /**
     * Get columns for the kanban view.
     */
    private function getKanbanColumns(): array
    {
        return [
            [
                'index'                 => 'id',
                'label'                 => trans('admin::app.leads.index.kanban.columns.id'),
                'type'                  => 'integer',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => null,
                'filterable_options'    => [],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'lead_value',
                'label'                 => trans('admin::app.leads.index.kanban.columns.lead-value'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => null,
                'filterable_options'    => [],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'user_id',
                'label'                 => trans('admin::app.leads.index.kanban.columns.sales-person'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => UserRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'id',
                    ],
                ],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'person.id',
                'label'                 => trans('admin::app.leads.index.kanban.columns.contact-person'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_options'    => [],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => PersonRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'id',
                    ],
                ],
            ],
            [
                'index'                 => 'lead_type_id',
                'label'                 => trans('admin::app.leads.index.kanban.columns.lead-type'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'dropdown',
                'filterable_options'    => $this->typeRepository->all(['name as label', 'id as value'])->toArray(),
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'lead_source_id',
                'label'                 => trans('admin::app.leads.index.kanban.columns.source'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'dropdown',
                'filterable_options'    => $this->sourceRepository->all(['name as label', 'id as value'])->toArray(),
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],

            [
                'index'                 => 'tags.name',
                'label'                 => trans('admin::app.leads.index.kanban.columns.tags'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_options'    => [],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => TagRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'name',
                    ],
                ],
            ],

            [
                'index'              => 'expected_close_date',
                'label'              => trans('admin::app.leads.index.kanban.columns.expected-close-date'),
                'type'               => 'date',
                'searchable'         => false,
                'searchable'         => false,
                'sortable'           => true,
                'filterable'         => true,
                'filterable_type'    => 'date_range',
                'filterable_options' => DateRangeOptionEnum::options(),
            ],

            [
                'index'              => 'created_at',
                'label'              => trans('admin::app.leads.index.kanban.columns.created-at'),
                'type'               => 'date',
                'searchable'         => false,
                'searchable'         => false,
                'sortable'           => true,
                'filterable'         => true,
                'filterable_type'    => 'date_range',
                'filterable_options' => DateRangeOptionEnum::options(),
            ],
        ];
    }
}
