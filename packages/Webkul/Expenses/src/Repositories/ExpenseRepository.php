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

    public function getDailyTotals(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate): array
    {
        return [
            'today' => [
                'revenue' => [
                    'formatted_total' => core()->formatBasePrice(
                        $this->getTotalByDateAndType($startDate, $endDate, true)
                    ),
                    'current' => $this->getTotalByDateAndType($startDate, $endDate, true),
                ],
                'expense' => [
                    'formatted_total' => core()->formatBasePrice(
                        $this->getTotalByDateAndType($startDate, $endDate, false)
                    ),
                    'current' => $this->getTotalByDateAndType($startDate, $endDate, false),
                ],
            ],
            'yesterday' => [
                'revenue' => [
                    'formatted_total' => core()->formatBasePrice(
                        $this->getTotalByDateAndType($startDate->copy()->subDay(), $endDate->copy()->subDay(), true)
                    ),
                    'current' => $this->getTotalByDateAndType($startDate->copy()->subDay(), $endDate->copy()->subDay(), true),
                ],
                'expense' => [
                    'formatted_total' => core()->formatBasePrice(
                        $this->getTotalByDateAndType($startDate->copy()->subDay(), $endDate->copy()->subDay(), false)
                    ),
                    'current' => $this->getTotalByDateAndType($startDate->copy()->subDay(), $endDate->copy()->subDay(), false),
                ],
            ],
        ];
    }


    private function getTotalByDateAndType($startDate, $endDate, bool $isRevenue): float
    {
        try {

            $expenseRevenueTotal = $this
                ->resetModel()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereHas('type', function ($query) {
                    $query->where('type_id', [ExpenseTypes::RECEITA_BRL, ExpenseTypes::RECEITA_USD]);
                })->sum('value');

            $leadRevenueTotal = DB::table('leads')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('billing_status_id', BillingStatus::STATUS_PAGO)
                ->sum('lead_value');
 $expenseTotal =  $this
                ->resetModel()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('type_id', [ExpenseTypes::DESPESAS_BRL, ExpenseTypes::DESPESAS_USD])
                ->sum('value');

            if($isRevenue === true){
                return $expenseRevenueTotal + $leadRevenueTotal;
            }else{
                return $expenseTotal;
            }

        } catch (\Exception $ex) {
            throw new \Exception("Erro ao calcular valores: " . $ex->getMessage());
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
