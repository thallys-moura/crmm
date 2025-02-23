<?php

namespace Webkul\Admin\Helpers\Reporting;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Webkul\DailyControls\Repositories\DailyControlsRepository;

class DailyControls extends AbstractReporting
{

    protected $productGroupId;

    public function __construct(protected DailyControlsRepository $dailyControlsRepository)
    {

        $this->setProductGroupId(request()['productGroup']);

        parent::__construct();
    }

    /**
     * Set the product group ID for filtering.
     *
     * @param  int|null  $productGroupId
     * @return self
     */
    public function setProductGroupId($productGroupId = null): self
    {
        if($productGroupId != NULL) $this->productGroupId = $productGroupId;
        return $this;
    }

    /**
     * Get the product group ID for filtering.
     *
     * @return int|null
     */
    public function getProductGroupId(): ?int
    {
        return $this->productGroupId;
    }

    /**
     * Get the total daily spending for a date range.
     *
     * @return float
     */
    public function getTotalDailySpending(): float
    {
        return DB::table('daily_controls')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->sum('daily_ad_spending');
    }

    /**
     * Get spending over time for a date range.
     *
     * @return array
     */
    public function getSpendingOverTime(): array
    {
        $spendingData = DB::table('daily_controls')
            ->selectRaw('DATE(created_at) as date, SUM(daily_ad_spending) as total_spending')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return $spendingData->map(function ($item) {
            return [
                'date' => Carbon::parse($item->date)->format('d M'),
                'spending' => (float) $item->total_spending,
            ];
        })->toArray();
    }

    /**
     * Get the average daily spending for a date range.
     *
     * @return float
     */
    public function getAverageDailySpending(): float
    {
        return DB::table('daily_controls')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->avg('daily_ad_spending');
    }

    /**
     * Retrieves total daily controls value and their progress.
     */
    public function getTotalLostDailyControlsValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getTotalDailyControlsValue($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getTotalDailyControlsValue($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    public function getTotalWowDailyControlsValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getTotalRevenueValue($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getTotalRevenueValue($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }


    /**
     * Retrieves average DailyControls value and their progress.
     */
    public function getAverageDailyControlsRevenueValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getAverageDailyControlsValue($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getAverageDailyControlsValue($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    /**
     * Retrieves total DailyControls and their progress.
     */
    public function getTotalDailyControlsProgress(): array
    {
        return [
            'previous' => $previous = $this->getTotalDailyControls($this->lastStartDate, $this->lastEndDate),
            'current'  => $current = $this->getTotalDailyControls($this->startDate, $this->endDate),
            'progress' => $this->getPercentageChange($previous, $current),
        ];
    }

    /**
     * Retrieves average DailyControls Expenses value and their progress.
     */
    public function getAverageExpenses(): array
    {
        return [
            'previous'        => $previous = $this->getAverageExpensesValues($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getAverageExpensesValues($this->startDate, $this->endDate),
            'formatted_expenses' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    /**
     * Retrieves total daily controls value for a date range.
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     * @return float|null
     */
    public function getTotalDailyControlsValue($startDate, $endDate): ?float
    {
        return $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->sum('daily_ad_spending');
    }

    public function getAverageLeadsPerDayValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getAverageLeadsPerDay($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getAverageLeadsPerDay($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    public function getAverageCostPerLeadValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getAverageCostPerLead($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getAverageCostPerLead($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    public function getAverageCallsPerDayValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getAverageCallsPerDay($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getAverageCallsPerDay($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    public function getAverageSalesPerDayValueProgress(): array
    {
        return [
            'previous'        => $previous = $this->getAverageSalesPerDay($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getAverageSalesPerDay($this->startDate, $this->endDate),
            'formatted_total' => core()->formatBasePrice($current),
            'progress'        => $this->getPercentageChange($previous, $current),
        ];
    }

    public function getAverageCostPerLead($startDate, $endDate): float
    {
        $result = $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->selectRaw('SUM(daily_ad_spending) as total_spending, SUM(leads_count) as total_leads')
            ->first();
        $totalSpending = $result->total_spending ?? 0;
        $totalLeads = $result->total_leads ?? 0;

        if ($totalLeads === 0) {
            return 0;
        }

        return $totalSpending / $totalLeads;
    }

    public function getAverageCallsPerDay($startDate, $endDate): float
    {
        $result = $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->selectRaw('SUM(calls_made) as total_calls, COUNT(DISTINCT date) as days_with_calls')
            ->first();

        $totalCalls = $result->total_calls ?? 0;
        $daysWithCalls = $result->days_with_calls ?? 0;

        if ($daysWithCalls === 0) {
            return 0;
        }

        return $totalCalls / $daysWithCalls;
    }

    public function getAverageSalesPerDay($startDate, $endDate): float
    {
        $result = $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->selectRaw('SUM(sales) as total_sales, COUNT(DISTINCT date) as days_with_sales')
            ->first();

        $totalSales = $result->total_sales ?? 0;
        $daysWithSales = $result->days_with_sales ?? 0;

        if ($daysWithSales === 0) {
            return 0;
        }

        return $totalSales / $daysWithSales;
    }

    public function getAverageLeadsPerDay($startDate, $endDate): float
    {
        $result = $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->selectRaw('SUM(leads_count) as total_leads, COUNT(DISTINCT date) as days_with_leads')
            ->first();

        $totalLeads = $result->total_leads ?? 0;
        $daysWithLeads = $result->days_with_leads ?? 0;

        if ($daysWithLeads === 0) {
            return 0;
        }

        return $totalLeads / $daysWithLeads;
    }
    /**
     * Get expenses grouped by sources for a date range.
     *
     * @return array
     */
    public function getExpensesBySources(): array
    {
        return DB::table('daily_controls')
            ->join('sources', 'daily_controls.source_id', '=', 'sources.id')
            ->select('sources.name as source_name', DB::raw('SUM(daily_controls.daily_ad_spending) as total'))
            ->whereBetween('daily_controls.date', [$this->startDate, $this->endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->groupBy('daily_controls.source_id', 'sources.name')
            ->get()
            ->toArray();
    }


    public function getExpensesByDailyControls(): array
    {
        return DB::table('daily_controls')
            ->join('product_group', 'daily_controls.product_group_id', '=', 'product_group.id')
            ->select(
                'product_group.name as group_name',
                DB::raw('SUM(daily_controls.daily_ad_spending) as total')
            )
            ->whereBetween('daily_controls.date', [$this->startDate, $this->endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->groupBy('daily_controls.product_group_id', 'product_group.name')
            ->get()
            ->toArray();
    }

    protected function getTotalRevenueValue($startDate, $endDate): float
    {
        return DB::table('daily_controls')
            ->whereBetween('date', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->sum('total_revenue');
    }

    /**
     * Retrieves daily controls statistics over time for a specific product group.
     *
     * @param  int  $groupId
     * @return array
     */
    public function getDailyControlsOverTimeByGroup(int $groupId): array
    {
        $query = DB::table('daily_controls')
            ->select(
                DB::raw('DATE(date) as date'),
                DB::raw('SUM(daily_ad_spending) as total_spending')
            )
            ->where('product_group_id', $groupId)
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return $query->map(function ($item) {
            return [
                'label' => Carbon::parse($item->date)->format('d M'),
                'total' => (float) $item->total_spending,
            ];
        })->toArray();
    }

    /**
     * Retrieves average DailyControls value
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     */
    public function getAverageDailyControlsValue($startDate, $endDate): float
    {
        return $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->avg('total_revenue') ?? 0;
    }

    public function getROI(): array
    {
        return [
            'previous'        => $previous = $this->getROIDailyControls($this->lastStartDate, $this->lastEndDate),
            'current'         => $current = $this->getROIDailyControls($this->startDate, $this->endDate),
            'formatted_total' => number_format($current, 2) . '%',
            'progress'        => $this->getROIDailyControls($previous, $current),
        ];
    }

    public function getROIDailyControls($startDate, $endDate): float
    {
        return $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($this->productGroupId, function ($query) {
                $query->where('product_group_id', $this->productGroupId);
            })
            ->whereNotNull('total_revenue')
            ->get()
            ->map(function ($dailyControl) {
                return ($dailyControl->total_revenue - $dailyControl->daily_ad_spending) / $dailyControl->daily_ad_spending * 100;
            })
            ->average() ?? 0;
    }


    /**
     * Retrieves average Expenses DailyControls value
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     */
    public function getAverageExpensesValues($startDate, $endDate): float
    {
        return $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->avg('daily_ad_spending') ?? 0;
    }

    /**
     * Retrieves total DailyControls by date
     *
     * @param  \Carbon\Carbon  $startDate
     * @param  \Carbon\Carbon  $endDate
     */
    public function getTotalDailyControls($startDate, $endDate): int
    {
        return $this->dailyControlsRepository
            ->resetModel()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

}
