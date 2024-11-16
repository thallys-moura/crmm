<?php

namespace Webkul\Admin\Helpers\Reporting;

use Webkul\Quote\Repositories\QuoteRepository;

class Quote extends AbstractReporting
{
    /**
     * Create a helper instance.
     *
     * @return void
     */
    public function __construct(protected QuoteRepository $quoteRepository)
    {
        parent::__construct();
    }

    /**
     * Retrieves total quotes and their progress.
     */
    public function getTotalQuotesProgress(): array
    {
        return [
            'previous' => $previous = $this->getTotalQuotes($this->lastStartDate, $this->lastEndDate),
            'current'  => $current = $this->getTotalQuotes($this->startDate, $this->endDate),
            'progress' => $this->getPercentageChange($previous, $current),
        ];
    }


        /**
     * Get filtered report data based on input filters.
     *
     */
    public function getQuantitativeQuotes()
    {   
 
        $startDate = data_get(request()->all(), 'params.startDate');
        $endDate = data_get(request()->all(), 'params.endDate');
        $seller = data_get(request()->all(), 'params.seller');
        $product = data_get(request()->all(), 'params.product');

        // Extrai os filtros da requisição
        $filters = [$startDate, $endDate, $seller, $product];

        $query = $this->quoteRepository
        ->resetModel()
        ->leftJoin('quote_items', 'quotes.id', '=', 'quote_items.quote_id') 
        ->leftJoin('products as product', 'quote_items.product_id', '=', 'product.id') 
        ->select(
            'quotes.*',
            \DB::raw('SUM(grand_total) as total_revenue'),
            'quote_items.product_id',
            'product.name as product_name'
        );

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('quotes.created_at', [$startDate, $endDate]);
        }

        if (!empty($seller)) {
            $query->where('quotes.user_id', $seller);
        }

        if (!empty($product)) {
            $query->where('quote_items.product_id', $product);
        }

        $query->groupBy('quotes.id', 'quote_items.product_id')
        ->orderBy('total_revenue', 'desc');

        $results = $query->with(['user'])->get();

        // Formata os resultados conforme necessário para os cards
        $formattedResults = [
            'sellers' => $results->groupBy('user_id')->map(function ($quotes, $userId) {
                return [
                    'id' => $userId,
                    'name' => optional($quotes->first()->user)->name,
                    'sales' => $quotes->count(),
                ];
            })->values(),
            'totalRevenue' => $results->sum('grand_total'), 
            'totalUnitsSold' => $results->count(),
            'products' => $results->groupBy('product_id')->map(function ($quotes, $productId) {
                $firstQuote = $quotes->first();
                
                $productName = $firstQuote->product_name ?? 'N/A'; 
                return [
                    'id' => $productId,
                    'name' => $productName,
                    'sales' => $quotes->count(),
                ];
            })->values(),
        ];

        // Retorna os dados como JSON
        return $formattedResults;
    }

    /**
     * Retrieves total quotes by date
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     */
    public function getTotalQuotes($startDate, $endDate): int
    {
        return $this->quoteRepository
            ->resetModel()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }
}
