<?php

namespace Webkul\Admin\Http\Controllers\DailyControls;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\DailyControls\Repositories\DailyControlsRepository;
use Webkul\User\Repositories\UserRepository;
use Webkul\Admin\DataGrids\DailyControls\DailyControlsDataGrid;
use Webkul\Admin\Helpers\DailyControlsHelper;
use Webkul\DailyControls\Contracts\DailyControls;

class DailyControlsController extends Controller
{

    protected $dailyControls;

    
    protected $typeFunctions = [
        'revenue-stats' => 'getRevenueStats',
        'revenue-by-source'   => 'getTotalExpensesBySources',
        'expenses-by-product-group' => 'getTotalExpensesByProductGroups',
        'total-expenses'          => 'getTotalDailyControlsStats',
    ];

    /**
     * Cria uma nova instância do controller.
     *
     * @param  DailyControlsRepository  $dailyControlRepository
     * @param  UserRepository          $userRepository
     * @return void
     */
    public function __construct(
        protected DailyControlsHelper $dailyControlsHelper,
        protected DailyControlsRepository $dailyControlRepository,
        protected UserRepository $userRepository
    ) {
    }

    /**
     * Exibe a lista de registros de DailyControls.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(DailyControlsDataGrid::class)->process();
        }
        return view('admin::daily_controls.index')->with([
            'startDate' => $this->dailyControlsHelper->getStartDate(),
            'endDate'   => $this->dailyControlsHelper->getEndDate(),
        ]);
    }

    /**
     * Exibe o formulário para criar um novo registro de DailyControl.
     */
    public function create(): View
    {
        $users = $this->userRepository->all();
        $sources = $this->dailyControlRepository->getSources();
        $groups = $this->dailyControlRepository->getProductGroups();

        return view('admin::daily_controls.create', compact('users', 'sources', 'groups'));
    }

    /**
     * Armazena um novo registro de DailyControl no banco de dados.
     */
    public function store(): RedirectResponse
    {
        try{

            $data = request()->all();

            $this->dailyControlRepository->create($data);

            
        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', __('Ocorreu um erro ao salvar o controle diário.'))
                ->withInput();
        }
       

        return redirect()->route('admin.daily_controls.index')
            ->with('success', trans('admin::app.daily_controls.index.create-success'));
    }

    /**
     * Exibe o formulário para editar um registro de DailyControl.
     */
    public function edit($id): View
    {
        $dailyControl = $this->dailyControlRepository->find($id);
        $users = $this->userRepository->all();
        $sources = $this->dailyControlRepository->getSources();
        $groups = $this->dailyControlRepository->getProductGroups();
        \Log::info($dailyControl);
        return view('admin::daily_controls.edit', compact('dailyControl', 'users', 'sources', 'groups'));
    }

    /**
     * Atualiza um registro de DailyControl existente.
     */
    public function update($id): RedirectResponse
    {
        Event::dispatch('daily_control.update.before', $id);

        $data = request()->all();

        $this->dailyControlRepository->update($data, $id);

        Event::dispatch('daily_control.update.after');

        return redirect()->route('admin.daily_controls.index')
            ->with('success', trans('admin::app.daily_controls.index.update-success'));
    }

    /**
     * Remove um registro de DailyControl do banco de dados.
     */
    public function destroy($id): JsonResponse
    {
        try {
            Event::dispatch('daily_control.delete.before', $id);

            $this->dailyControlRepository->delete($id);

            Event::dispatch('daily_control.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.daily_controls.index.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.daily_controls.index.delete-failed'),
            ], 400);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats()
    {   
        $stats = $this->dailyControlsHelper->{$this->typeFunctions[request()->query('type')]}();
        
        return response()->json([
            'statistics' => $stats,
            'date_range' => $this->dailyControlsHelper->getDateRange(),
        ]);
    }

}
