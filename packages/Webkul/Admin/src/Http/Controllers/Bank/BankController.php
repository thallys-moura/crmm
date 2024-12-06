<?php

namespace Webkul\Admin\Http\Controllers\Bank;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Prettus\Repository\Criteria\RequestCriteria;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Bank\Repositories\BankRepository;
use Webkul\User\Repositories\UserRepository;
use Webkul\Admin\DataGrids\Bank\BankDataGrid;
use Webkul\Admin\DataGrids\Expense\ExpenseDataGrid;

use Webkul\Expenses\Repositories\ExpenseTypeRepository;
use Webkul\Expenses\Repositories\ExpenseRepository;

class BankController extends Controller
{
    /**
     * Cria uma nova instância do controller.
     *
     * @param  BankRepository  $bankRepository
     * @return void
     */
    public function __construct(
        protected UserRepository $userRepository,
        protected BankRepository $bankRepository,
        protected ExpenseTypeRepository $expenseTypeRepository,
        protected ExpenseRepository $expenseRepository
    ) {
        $this->expenseTypeRepository = $expenseTypeRepository;
        $this->expenseRepository = $expenseRepository;

    }

    /**
     * Exibe a lista de registros de banco.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            //As informações salvas no módulo de despesas são listadas no banco
            return datagrid(ExpenseDataGrid::class)->process();
        }

        // Obter totais agrupados por tipo (receita e despesa)
        $totals = $this->expenseRepository->getDailyTotals();
        // Obter os saldos de receitas por tipo
        $revenueBalances = $this->expenseRepository->getCurrentRevenueBalances();



        return view('admin::bank.index', [
            'todayRevenue' => $totals['today']['revenue'],
            'todayExpense' => $totals['today']['expense'],
            'yesterdayRevenue' => $totals['yesterday']['revenue'],
            'yesterdayExpense' => $totals['yesterday']['expense'],
            'revenueBalances' => $revenueBalances,
        ]);

    }

    /**
     * Exibe o formulário para criar um novo registro de banco.
     */
    public function create(): View
    {
        $bank = $this->bankRepository->find(request('id'));
        $users = $this->userRepository->all();

        return view('admin::bank.create', compact('bank', 'users'));
    }

    /**
     * Armazena um novo registro de banco no banco de dados.
     */
    public function store(): RedirectResponse
    {
        Event::dispatch('bank.create.before');

        $data = request()->all();

        $bank = $this->bankRepository->create($data);

        Event::dispatch('bank.create.after', $bank);

        return redirect()->route('admin.bank.index')
            ->with('success', trans('admin::app.bank.index.create-success'));
    }

    /**
     * Exibe o formulário de edição de um registro de banco.
     */
    public function edit($id): View
    {
        $bank = $this->bankRepository->find($id);
        $users = $this->userRepository->all();

        return view('admin::bank.edit', compact('bank', 'users'));
    }

    /**
     * Atualiza um registro de banco existente.
     */
    public function update($id): RedirectResponse
    {
        Event::dispatch('bank.update.before', $id);

        $data = request()->all();

        $bank = $this->bankRepository->update($data, $id);

        Event::dispatch('bank.update.after', $bank);

        return redirect()->route('admin.bank.index')
            ->with('success', trans('admin::app.bank.index.update-success'));
    }

    /**
     * Remove um registro de banco do banco de dados.
     */
    public function destroy($id): JsonResponse
    {
        try {
            Event::dispatch('bank.delete.before', $id);

            $this->bankRepository->delete($id);

            Event::dispatch('bank.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.bank.index.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.bank.index.delete-failed'),
            ], 400);
        }
    }
}
