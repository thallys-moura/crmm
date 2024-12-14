<?php

namespace Webkul\Admin\Http\Controllers\Remarketing;

use Illuminate\Http\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Remarketing\Repositories\RemarketingRepository;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Remarketing\RemarketingDatagrid;
use Webkul\Lead\Repositories\LeadRepository;
use Webkul\Quote\Models\PaymentMethod;

class RemarketingController extends Controller
{
    /**
     * @var RemarketingRepository
     */
    protected $remarketingRepository;

    /**
     * Create a new controller instance.
     *
     * @param  RemarketingRepository  $remarketingRepository
     */
    public function __construct(RemarketingRepository $remarketingRepository)
    {
        $this->remarketingRepository = $remarketingRepository;
    }

    /**
     * Exibe a lista de remarketing.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            // Retorna os dados em formato JSON para carregamento via datagrid
            return datagrid(RemarketingDatagrid::class)->process();
        }
    
        // Retornar a view com os dados
        return view('admin::remarketing.index');
    }

    /**
     * Exibe os detalhes de um remarketing específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $remarketing = $this->remarketingRepository->findOrFail($id);

        return view('admin::remarketing.view', compact('remarketing'));
    }

    /**
     * Exibe o formulário de criação de remarketing.
     *
     * @param  int|null  $id
     * @return \Illuminate\View\View
     */
    public function create($id = null)
    {
        $paymentMethods = PaymentMethod::pluck('name', 'id'); // Obtenha todos os métodos de pagamento

        return view('admin::remarketing.create', compact( 'paymentMethods'));
    }

    /**
     * Salva um novo remarketing.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'quote_id' => 'nullable|exists:quotes,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->remarketingRepository->create($validatedData);

        return redirect()->route('admin.remarketing.index')->with('success', 'Remarketing criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de remarketing.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $remarketing = $this->remarketingRepository->findOrFail($id);

        return view('admin::remarketing.edit', compact('remarketing'));
    }

    /**
     * Atualiza um remarketing existente.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lead_id' => 'nullable|exists:leads,id',
            'quote_id' => 'nullable|exists:quotes,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->remarketingRepository->update($validatedData, $id);

        return redirect()->route('admin.remarketing.index')->with('success', 'Remarketing atualizado com sucesso!');
    }

    /**
     * Exclui um remarketing.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->remarketingRepository->delete($id);

        return redirect()->route('admin.remarketing.index')->with('success', 'Remarketing excluído com sucesso!');
    }

    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        // Obter os registros a serem excluídos
        $remarketingItems = $this->remarketingRepository->findWhereIn('id', $massDestroyRequest->input('indices'));
    
        try {
            foreach ($remarketingItems as $remarketing) {
                // Evento antes de excluir
                Event::dispatch('remarketing.delete.before', $remarketing->id);
    
                // Excluir o registro
                $this->remarketingRepository->delete($remarketing->id);
    
                // Evento após excluir
                Event::dispatch('remarketing.delete.after', $remarketing->id);
            }
    
            return response()->json([
                'message' => trans('admin::app.remarketing.index.delete-success'),
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.remarketing.index.delete-failed'),
            ], 400);
        }
    }

    /**
     * Pesquisa remarketing.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $results = $this->remarketingRepository->findWhere([
            ['title', 'LIKE', "%{$query}%"]
        ]);

        return response()->json($results);
    }
}
