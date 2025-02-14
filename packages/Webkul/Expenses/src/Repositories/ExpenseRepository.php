<?php

namespace Webkul\Expenses\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Webkul\Admin\Constants\ExpenseTypes;
use Webkul\Admin\Constants\BillingStatus;
use Webkul\DataGrid\ColumnTypes\Boolean;

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
        $expenseRevenueTotal = $this->model
            ->whereHas('type', function ($query) {
                $query->where('type_id', [ExpenseTypes::RECEITA_BRL, ExpenseTypes::RECEITA_USD]);
            })
            ->sum('value');

        $leadRevenueTotal = DB::table('leads')
            ->where('billing_status_id', BillingStatus::STATUS_PAGO)
            ->sum('lead_value');

        $expenseTotal = $this->model
            ->whereIn('type_id', [ExpenseTypes::DESPESAS_BRL, ExpenseTypes::DESPESAS_USD])
            ->sum('value');

        if($isRevenue === true){
            return $expenseRevenueTotal + $leadRevenueTotal;
        }else{
            return $expenseTotal;
        }
    }

    public function getRevenueTypes()
    {
        return $this->model->where('is_revenue', true)->get();
    }

    public function getExpenseTypes()
    {
        return $this->model->where('is_revenue', false)->get();
    }

    public function getCurrentRevenueBalances(): float
    {
        $expenseRevenueTotal = $this->model
        ->whereHas('type', function ($query) {
            $query->where('is_revenue', true);
        })
        ->sum('value');

        $leadRevenueTotal = DB::table('leads')
            ->where('billing_status_id', BillingStatus::STATUS_PAGO)
            ->sum('lead_value');

        $expenseTotal = $this->model
            ->whereIn('type_id', [ExpenseTypes::DESPESAS_BRL, ExpenseTypes::DESPESAS_USD])
            ->sum('value');

        return ($expenseRevenueTotal + $leadRevenueTotal) - $expenseTotal;

    }

}
