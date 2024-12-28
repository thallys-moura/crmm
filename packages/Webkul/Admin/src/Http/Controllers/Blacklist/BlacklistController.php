<?php 

namespace Webkul\Admin\Http\Controllers\Blacklist;
use Illuminate\Http\Request;
use Webkul\Core\Traits\PDFHandler;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\LeadForm;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Admin\Http\Requests\MassUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webkul\Blacklist\Repositories\BlacklistRepository;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\DataGrids\Blacklist\BlacklistDataGrid;
use Webkul\Lead\Models\Lead;
use Webkul\Blacklist\Models\Blacklist;
use Webkul\User\Models\User;

class BlacklistController extends Controller
{
    protected $blackListRepository;

    public function __construct(BlacklistRepository $blackListRepository)
    {
        $this->blackListRepository = $blackListRepository;
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            // Retorna os dados em formato JSON para carregamento via datagrid
            return datagrid(BlacklistDataGrid::class)->process();
        }
    
        // Retornar a view com os dados
        return view('admin::blacklist.index');
    }
    

    public function create(): View
    {
        return view('admin::blacklist.create');
    }

    public function _store(): RedirectResponse
    {
        $data = request()->all();

        $this->blackListRepository->create($data);

        return redirect()->route('admin.blacklist.index')
            ->with('success', 'Item adicionado à Black List com sucesso.');
    }

    public function store(Request $request)
    {   
        $data = $request->all();
        $lead = $data['leads'];
        $user = auth()->user();
        $seller = User::findOrFail($lead['user']['id']);
        $person = $lead['person'];

        $lead = Lead::findOrFail($lead['id']);

         // Verifica se o lead já está na blacklist
         if (Blacklist::where('lead_id', $person['id'])->exists()) {
            return response()->json(['message' => 'Cliente já está na blacklist.'], 400);
        }

        $blacklistData = [
            'lead_id' => $lead->id,
            'seller_id' => $seller->id,
            'person_id' => $person['id'],
            'observations' => $request->input('observacao'),
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
            'sale_date' => $lead['quotes'][0]['created_at']
        ];


        // Insere na tabela blacklist
        $this->blackListRepository->create($blacklistData);

        // Atualiza o status do lead, se necessário
        //$lead->update(['is_blacklisted' => true]);

        return response()->json(['message' => 'Lead adicionado à blacklist com sucesso.']);
    }

    public function edit($id): View
    {
        $blackList = $this->blackListRepository->findOrFail($id);

        return view('admin::blacklist.edit', compact('blackList'));
    }

    public function update($id): RedirectResponse
    {
        $data = request()->all();

        $this->blackListRepository->update($data, $id);

        return redirect()->route('admin.blacklist.index')
            ->with('success', 'Item atualizado com sucesso.');
    }

    public function destroy($id): JsonResponse
    {
        $this->blackListRepository->delete($id);

        return response()->json([
            'message' => 'Item removido da Black List com sucesso.',
        ]);
    }

        /**
     * Mass Delete the specified resources.
     */
    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $items = $this->blackListRepository->findWhereIn('id', $massDestroyRequest->input('indices'));

        try {
            foreach ($items as $item) {
                Event::dispatch('quote.delete.before', $item->id);

                $this->blackListRepository->delete($item->id);

                Event::dispatch('quote.delete.after', $item->id);
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
     * Adiciona um lead à blacklist.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToBlacklist(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'leads' => 'required|exists:leads,id',
            'observacao' => 'string|max:255',
        ]);

        // Captura os dados do lead e do usuário autenticado
        $leadId = $request->input('leads');
        
        $lead = Lead::findOrFail($leadId); // Garante que o lead existe
        $user = User::findOrFail(auth()->user());

        // Verifica se o lead já está na blacklist
        if (Blacklist::where('lead_id', $leadId)->exists()) {
            return response()->json(['message' => 'O lead já está na blacklist.'], 400);
        }

        // Prepara os dados para inserir na blacklist
        $blacklistData = [
            'lead_id' => $lead->id,
            'seller_id' => $lead->user_id,
            'person_id' => $lead->person->id,
            'observacao' => $request->input('observacao'),
            'added_by' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insere na tabela blacklist
        Blacklist::create($blacklistData);

        // Atualiza o status do lead, se necessário
        $lead->update(['is_blacklisted' => true]);

        return response()->json(['message' => 'Lead adicionado à blacklist com sucesso.']);
    }

}
