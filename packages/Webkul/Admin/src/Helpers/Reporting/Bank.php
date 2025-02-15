<?php

namespace Webkul\Admin\Helpers\Reporting;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Webkul\Bank\Repositories\BankRepository;
use Webkul\admin\Constants\ExpenseTypes;
use Webkul\Expenses\Repositories\ExpenseRepository;

class Bank extends AbstractReporting
{
    /**
     * Construtor do Reporting.
     */
    public function __construct(
        protected BankRepository $bankRepository,
        protected ExpenseRepository $expenseRepository
    ){
        parent::__construct();
    }

    /**
     * Retorna as estatísticas de movimentações financeiras.
     */
    public function getRevenueStats(): array
    {
        return [
            'todayRevenue'  => $this->getTotalByDateAndType($this->startDate, $this->endDate, true),
            'todayExpense'  => $this->getTotalByDateAndType($this->startDate, $this->endDate, false),
        ];
    }

    /**
     * Retorna o saldo atual (Receitas - Despesas).
     */
    public function getBalanceStats(): array
    {
        $totalRevenue = $this->getTotalByDateAndType($this->startDate, $this->endDate, true);
        $totalExpense = $this->getTotalByDateAndType($this->startDate, $this->endDate, false);

        return ['totalBalance' => $totalRevenue - $totalExpense];
    }

    /**
     * Obtém o total de receitas e despesas no período filtrado.
     */
    private function getTotalByDateAndType($startDate, $endDate, bool $isRevenue): float
    {
        try {
            // Se for receita, soma receitas de expenses + valores de leads fechados
            if ($isRevenue) {
                $totalExpensesRevenue = $this->expenseRepository
                    ->resetModel()
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->whereHas('type', function ($query) {
                        $query->where('is_revenue', true);
                    })
                    ->sum('value');

                $totalLeadRevenue = DB::table('leads')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->where('billing_status_id', BillingStatus::STATUS_PAGO)
                    ->sum('lead_value');

                return $totalExpensesRevenue + $totalLeadRevenue;
            }

            // Caso seja despesa, soma apenas os valores da tabela `expenses`
            return $this->expenseRepository
                ->resetModel()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('type_id', [ExpenseTypes::DESPESAS_BRL, ExpenseTypes::DESPESAS_USD])
                ->sum('value');

        } catch (\Exception $ex) {
            throw new \Exception("Erro ao calcular valores: " . $ex->getMessage());
        }
    }
}
