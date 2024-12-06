<?php

namespace Webkul\Expenses\Repositories;

use Webkul\Core\Eloquent\Repository;

class ExpenseRepository extends Repository
{
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Expenses\Models\Expense';
    }

    /**
     * Cria ou atualiza uma despesa.
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return \Webkul\Expenses\Models\Expense
     */
    public function create(array $data)
    {

        $expense = parent::create($data);

        return $expense;
    }

    /**
     * Atualiza uma despesa existente.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\Expenses\Models\Expense
     */
    public function update(array $data, $id)
    {
        $expense = parent::update($data, $id);

        return $expense;
    }

    /**
     * Remove uma despesa pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    public function getDailyTotals(): array
    {
        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
    
        return [
            'today' => [
                'revenue' => $this->getTotalByDateAndType($today, true),  // Receitas
                'expense' => $this->getTotalByDateAndType($today, false), // Despesas
            ],
            'yesterday' => [
                'revenue' => $this->getTotalByDateAndType($yesterday, true), // Receitas
                'expense' => $this->getTotalByDateAndType($yesterday, false), // Despesas
            ],
        ];
    }
    
    private function getTotalByDateAndType(\Carbon\Carbon $date, bool $isRevenue): float
    {
        return $this->model
            ->whereDate('created_at', $date)
            ->whereHas('type', function ($query) use ($isRevenue) {
                $query->where('is_revenue', $isRevenue);
            })
            ->sum('value');
    }

    public function getRevenueTypes()
    {
        return $this->model->where('is_revenue', true)->get();
    }

    public function getExpenseTypes()
    {
        return $this->model->where('is_revenue', false)->get();
    }

    public function getCurrentRevenueBalances(): array
    {
        return $this->model
            ->selectRaw('expense_types.name, SUM(expenses.value) as total')
            ->join('expense_types', 'expenses.type_id', '=', 'expense_types.id')
            ->where('expense_types.is_revenue', true)
            ->groupBy('expense_types.id', 'expense_types.name')
            ->pluck('total', 'expense_types.name')
            ->toArray();
    }

}