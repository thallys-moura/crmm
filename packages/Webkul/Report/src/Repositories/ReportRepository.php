<?php 

namespace Webkul\Reports\Repositories;

use Webkul\Reports\Contracts\Report;
use Webkul\Reports\Models\Lead;
use Webkul\Admin\Constants\BillingStatus;
use Illuminate\Support\Facades\DB;

class ReportRepository implements Report
{
    /**
     * Obtém a receita por dia de pagamento dentro do intervalo de datas fornecido.
     *
     * @param string $startDate
     * @param string $endDate
     * @return mixed
     */
    public function getTotalWonLeadValueByPaymentDays(string $startDate, string $endDate)
    {
        return Lead::select(
                DB::raw('DAYNAME(payment_date) as payment_day_name'), // Nome do dia (segunda, terça, etc.)
                DB::raw('SUM(lead_value) as total') // Soma do valor dos leads
            )
            ->where('billing_status_id', BillingStatus::STATUS_PAGO) // Somente leads com status "Pago"
            ->whereBetween('created_at', [$startDate, $endDate]) // Filtro por intervalo de datas
            ->groupBy(DB::raw('DAYNAME(payment_date)')) // Agrupar pelo nome do dia
            ->orderBy(DB::raw('DAYOFWEEK(payment_date)'), 'asc') // Ordenar pelos dias da semana (1 = domingo, 7 = sábado)
            ->get();
    }
}