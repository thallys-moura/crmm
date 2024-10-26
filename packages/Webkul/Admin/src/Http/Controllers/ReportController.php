<?php

namespace Webkul\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Lead\Repositories\LeadRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\User\Repositories\UserRepository;

use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Webkul\Admin\Constants\BillingStatus;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Traits\PDFHandler;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    use PDFHandler;

    protected $leadRepository;
    protected $productRepository;
    protected $userRepository;

    public function __construct(
        LeadRepository $leadRepository,
        ProductRepository $productRepository,
        UserRepository $userRepository
    ) {
        $this->leadRepository = $leadRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Filtra os relatórios com base nos parâmetros do filtro.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterReports(Request $request): Response|StreamedResponse
    {

        // Validação básica dos parâmetros
        $request->validate([
            'startDate'   => 'required|date',
            'endDate'     => 'required|date',
        ]);

        // Pega os valores dos filtros
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $seller = $request->input('seller');
        $productId = $request->input('product');
        $allSellers = $request->input('allSellers', false);  // Filtro de todos os vendedores
        $allProducts = $request->input('allProducts', false);  // Filtro de todos os produtos

        // Consulta básica de leads
        $query = DB::table('leads')
            ->join('lead_quotes', 'leads.id', '=', 'lead_quotes.lead_id')
            ->join('quotes', 'lead_quotes.quote_id', '=', 'quotes.id')
            ->join('quote_items', 'quotes.id', '=', 'quote_items.quote_id')
            ->whereBetween('leads.created_at', [$startDate, $endDate]);

        // Filtro de vendedor (seller)
        if ($allSellers != 'true' && $seller) {
            $query->where('leads.user_id', $seller);
        }

        // Filtro de produtos (product)
        if ($allProducts != 'true' && $productId) {
            $query->where('quote_items.product_id', $productId);
            $product = DB::table('products')->find($productId); // Obtém o produto
        } else {
            $product = null; // Nenhum produto específico selecionado
        }

        // Obter leads e fazer o join com as quotes e payment_methods
        $leads = $query->select('leads.*', 'quotes.payment_method_id', 'quotes.grand_total', 'quote_items.product_id')
            ->get();

        // Calcular resumo das vendas
        $summary = [
            'total_sales' => $leads->count(),
            'total_paid' => $leads->where('billing_status_id', BillingStatus::STATUS_PAGO)->count(),
            'total_pending' => $leads->where('billing_status_id', BillingStatus::STATUS_PENDENTE)->count(),
            'total_unpaid' => $leads->where('billing_status_id', BillingStatus::STATUS_NAO_PAGO)->count(),
            'total_value' => $leads->sum('lead_value'),
            'total_value_paid' => $leads->where('billing_status_id', BillingStatus::STATUS_PAGO)->sum('lead_value'),
            'total_value_unpaid' => $leads->where('billing_status_id', BillingStatus::STATUS_NAO_PAGO)->sum('lead_value'),
            'weekly_avg_sales' => $this->calculateWeeklyAverageSales($startDate, $endDate, $leads)
        ];

        // Detalhamento das vendas
        $details = $leads->map(function($lead) {
            $createdAt = \Carbon\Carbon::parse($lead->created_at);

            return [
                'date' => $createdAt,
                'sale' => $lead->user_id,  // Exemplo: aqui você pode ajustar com base no user_id ou qualquer campo
                'client' => 'N/A',  // Ajuste de acordo com o que você precisa
                'payment_method' => $lead->payment_method_id,  // Pegando o método de pagamento de quotes
                'product' => $lead->product_id,  // Pegando o produto de quote_items
                'seller' => 'N/A',  // Ajuste de acordo com o que você precisa
                'value' => $lead->grand_total,  // Pegando o valor total de quotes
                'status' => $this->getBillingStatusLabel($lead->billing_status_id)
            ];
        });

        // Retornar os dados necessários para o front-end
        try {
            // Renderizar a visualização do PDF
    
                // Renderiza a view do PDF e faz o download
            return $this->downloadPDF(
                view('admin::dashboard.pdf', compact('summary', 'details', 'product'))->render(),
                'Relatorio_Vendas_' . now()->format('d-m-Y') . '.pdf'
            );

        } catch (\Exception $e) {
            return response()->make('Falha ao tentar gerar relatório de vendas: ' . $e->getMessage(), 500);
        }
    }

    protected function getBillingStatusLabel($billingStatusId)
    {
        switch ($billingStatusId) {
            case BillingStatus::STATUS_PAGO:
                return 'Pago';
            case BillingStatus::STATUS_PAGO_PARCELADO:
                return 'Pago Parcelado';
            case BillingStatus::STATUS_NAO_PAGO:
                return 'Não Pago';
            case BillingStatus::STATUS_CANCELADO:
                return 'Cancelado';
            case BillingStatus::STATUS_PENDENTE:
                return 'Pendente';
            default:
                return 'Desconhecido';
        }
    }

    protected function calculateWeeklyAverageSales($startDate, $endDate, $leads)
    {
        // Converte as datas para instâncias de Carbon
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        // Calcula o número de semanas entre as datas de início e fim
        $weeks = $start->diffInWeeks($end);

        // Verifica se o número de semanas é maior que 0 para evitar divisão por zero
        if ($weeks > 0) {
            // Calcula a média de vendas por semana
            $averageSalesPerWeek = $leads->count() / $weeks;
        } else {
            // Se houver menos de uma semana, considera todas as vendas para o período
            $averageSalesPerWeek = $leads->count();
        }

        return $averageSalesPerWeek;
    }

    /**
     * Método para listar usuários (vendedores) vinculados a leads.
     */
    public function getUsers()
    {
        // Consulta para obter os usuários (vendedores) que têm leads vinculados
        $users = $this->userRepository->all();

        // Retorna os usuários no formato JSON
        return response()->json($users);
    }


}