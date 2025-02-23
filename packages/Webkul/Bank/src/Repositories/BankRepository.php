<?php

namespace Webkul\Bank\Repositories;

use Exception;
use Webkul\Core\Eloquent\Repository;
use Webkul\Admin\Constants\ExpenseTypes;
use Webkul\Expenses\Repositories\ExpenseRepository;
use Webkul\Admin\Constants\BillingStatus;
use Illuminate\Support\Facades\DB;

class BankRepository extends Repository
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository) {
        $this->expenseRepository = $expenseRepository;
    }
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Bank\Models\Bank';
    }


    /**
     * Cria ou atualiza um registro de banco.
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return \Webkul\Bank\Models\Bank
     */
    public function create(array $data)
    {
        $bank = parent::create($data);

        return $bank;
    }

    /**
     * Atualiza um registro de banco existente.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\Bank\Models\Bank
     */
    public function update(array $data, $id)
    {
        $bank = parent::update($data, $id);

        return $bank;
    }

    /**
     * Remove um registro de banco pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    /**
     * Obtém as estatísticas de movimentações financeiras.
     */
    public function getRevenueStats($startDate, $endDate): array
    {
        return [
            'todayRevenue' => [
                'formatted_total' => core()->formatBasePrice(
                    $this->getTotalByDateAndType($startDate, $endDate, true)
                ),
                'current' => $this->getTotalByDateAndType($startDate, $endDate, true),
            ],
            'todayExpense' => [
                'formatted_total' => core()->formatBasePrice(
                    $this->getTotalByDateAndType($startDate, $endDate, false)
                ),
                'current' => $this->getTotalByDateAndType($startDate, $endDate, false),
            ],
        ];
    }

    /**
     * Obtém as estatísticas de saldo atual.
     */
    public function getBalanceStats($startDate, $endDate): array
    {
        $totalRevenue = $this->getTotalByType($startDate, $endDate, true);
        $totalExpense = $this->getTotalByType($startDate, $endDate, false);
        $totalBalance = $totalRevenue - $totalExpense;

        return [
            'totalBalance' => [
                'formatted_total' => core()->formatBasePrice($totalBalance),
                'current' => $totalBalance,
            ],
        ];
    }

    private function getTotalByType($startDate, $endDate, bool $isRevenue): float
    {
        try {

            $expenseRevenueTotal = $this->expenseRepository
                ->resetModel()
                ->whereHas('type', function ($query) {
                    $query->where('type_id', [ExpenseTypes::RECEITA_BRL, ExpenseTypes::RECEITA_USD]);
                })->sum('value');


            $leadRevenueTotal = DB::table('leads')
                ->where('billing_status_id', BillingStatus::STATUS_PAGO)
                ->sum('lead_value');

            $expenseTotal =  $this->expenseRepository
                ->resetModel()
                ->whereIn('type_id', [ExpenseTypes::DESPESAS_BRL, ExpenseTypes::DESPESAS_USD])
                ->sum('value');

            if($isRevenue === true){
                return $expenseRevenueTotal + $leadRevenueTotal;
            }else{
                return $expenseTotal;
            }

        } catch (Exception $ex) {
            throw new Exception("Erro ao calcular valores: " . $ex->getMessage());
        }
    }

    private function getTotalByDateAndType($startDate, $endDate, bool $isRevenue): float
    {
        try {

            $expenseRevenueTotal = $this->expenseRepository
                ->resetModel()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereHas('type', function ($query) {
                    $query->where('type_id', [ExpenseTypes::RECEITA_BRL, ExpenseTypes::RECEITA_USD]);
                })->sum('value');


            $leadRevenueTotal = DB::table('leads')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('billing_status_id', BillingStatus::STATUS_PAGO)
                ->sum('lead_value');

            $expenseTotal =  $this->expenseRepository
                ->resetModel()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('type_id', [ExpenseTypes::DESPESAS_BRL, ExpenseTypes::DESPESAS_USD])
                ->sum('value');

            if($isRevenue === true){
                return $expenseRevenueTotal + $leadRevenueTotal;
            }else{
                return $expenseTotal;
            }

        } catch (Exception $ex) {
            throw new Exception("Erro ao calcular valores: " . $ex->getMessage());
        }
    }


}
