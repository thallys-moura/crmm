<?php

namespace Webkul\Admin\Http\Controllers\Expense;

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
use Webkul\Expenses\Repositories\ExpenseRepository;
use Webkul\Expenses\Repositories\ExpenseTypeRepository;
use Webkul\User\Repositories\UserRepository;
use Webkul\Admin\DataGrids\Expense\ExpenseDataGrid;

class ExpenseController extends Controller
{
    /**
     * Cria uma nova instância do controller.
     *
     * @param  ExpenseRepository  $expenseRepository
     * @return void
     */
    public function __construct(
        protected UserRepository $userRepository, // Adicione o repositório de usuários
        protected ExpenseRepository $expenseRepository,
        protected ExpenseTypeRepository $expenseTypeRepository

    ) {
        $this->expenseTypeRepository = $expenseTypeRepository;
    }

    /**
     * Exibe a lista de despesas.
     *
     * 
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ExpenseDataGrid::class)->process();
        }

        return view('admin::expenses.index');
    }

        /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $expense = $this->expenseRepository->find(request('id'));
        $users = $this->userRepository->all();  // Carregar todos os usuários
        $expenseTypes = $this->expenseTypeRepository->all(); // Carregar tipos de despesa

        return view('admin::expenses.create', compact('expense', 'users', 'expenseTypes'));
    }

    /**
     * Armazena uma nova despesa no banco de dados.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        Event::dispatch('expenses.create.before');

        $data = request()->all();

        $expense = $this->expenseRepository->create($data);
        $expenseTypes = $this->expenseTypeRepository->all(); // Carregar tipos de despesa

        Event::dispatch('expenses.create.after', $expense);

        return redirect()->route('admin.expenses.index')
            ->with('success', trans('admin::app.expenses.index.create-success'));
    }

    /**
     * Exibe o formulário de edição de uma despesa.
     * 
     */
    public function edit($id): View
    {
        $expense = $this->expenseRepository->find($id);
        $expenseTypes = $this->expenseTypeRepository->all(); // Carregar tipos de despesa
        $users = $this->userRepository->all();  // Carregar todos os usuários

        return view('admin::expenses.edit', compact('expense', 'users', 'expenseTypes'));
    }

    /**
     * Atualiza uma despesa existente.
     *
     * @param  int  $id
     *
     */
    public function update($id): RedirectResponse
    {
        Event::dispatch('expenses.update.before', $id);

        $data = request()->all();

        $expense = $this->expenseRepository->update($data, $id);

        Event::dispatch('expenses.update.after', $expense);

        return redirect()->route('admin.expenses.index')
            ->with('success', trans('admin::app.expenses.index.update-success'));
    }

    /**
     * Remove uma despesa do banco de dados.
     *
     * @param  int  $id
     *
     */
    public function destroy($id): JsonResponse
    {
        try {
            Event::dispatch('expenses.delete.before', $id);

            $this->expenseRepository->delete($id);
    
            Event::dispatch('expenses.delete.after', $id);

            return response()->json([
                'message' => trans('admin::app.expenses.index.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('admin::app.expenses.index.delete-failed'),
            ], 400);
        }
    }
}