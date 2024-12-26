<?php

namespace Webkul\Admin\Helpers\Reporting;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Webkul\DailyControls\Repositories\DailyControlsRepository;

class DailyControls extends AbstractReporting
{
    public function __construct(protected DailyControlsRepository $dailyControlsRepository)
    {
        parent::__construct();
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
            ->sum('daily_ad_spending');
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
            ->groupBy('daily_controls.product_group_id', 'product_group.name')
            ->get()
            ->toArray();
    }

    protected function getTotalRevenueValue($startDate, $endDate): float
    {
        return DB::table('daily_controls')
            ->whereBetween('date', [$startDate, $endDate])
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
}
