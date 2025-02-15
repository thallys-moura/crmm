<?php

namespace Webkul\Admin\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Webkul\Admin\Helpers\Reporting\DailyControls;
use Illuminate\Support\Facades\DB;

class DailyControlsHelper
{
    /**
     * Create a helper instance.
     *
     * @return void
     */
    public function __construct(
        protected DailyControls $dailyControlReporting,
    ) {}

    /**
     * Returns the daily spending statistics.
     *
     * @return array
     */
    public function getDailySpendingStats(): array
    {
        return [
            'total_spending'       => $this->dailyControlReporting->getTotalDailySpending(),
            'average_spending'     => $this->dailyControlReporting->getAverageDailySpending(),
            'spending_over_time'   => $this->dailyControlReporting->getSpendingOverTime(),
        ];
    }

    
    /**
     * Get the start date for the control period.
     *
     * @return \Carbon\Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->dailyControlReporting->getStartDate();
    }

    /**
     * Get the end date for the control period.
     *
     * @return \Carbon\Carbon
     */
    public function getEndDate(): Carbon
    {
        return $this->dailyControlReporting->getEndDate();
    }

    /**
     * Returns the date range as a formatted string.
     *
     * @return string
     */
    public function getDateRange(): string
    {
        return $this->getStartDate()->format('d M').' - '.$this->getEndDate()->format('d M');
    }

    public function getRevenueStats(): array
    {
        return [
            'total_won_revenue'  => $this->dailyControlReporting->getTotalWowDailyControlsValueProgress(),
            'total_lost_revenue' => $this->dailyControlReporting->getTotalLostDailyControlsValueProgress(),
        ];
    }

    /**
     * Returns daily Controls revenue statistics by sources.
     */
    public function getTotalExpensesBySources(): mixed
    {
        return $this->dailyControlReporting->getExpensesBySources();
    }

    
    public function getTotalExpensesByProductGroups(): mixed
    {
        return $this->dailyControlReporting->getExpensesByDailyControls();
    }

    public function getAverageLeadsPerDay(): mixed
    {
        return $this->dailyControlReporting->getAverageLeadsPerDayValueProgress();
    }

    public function getAverageCostPerLead(): mixed
    {
        return $this->dailyControlReporting->getAverageCostPerLeadValueProgress();
    }

    public function getAverageCallsPerDay(): mixed
    {
        return $this->dailyControlReporting->getAverageCallsPerDayValueProgress();
    }

    public function getAverageSalesPerDay(): mixed
    {
        return $this->dailyControlReporting->getAverageSalesPerDayValueProgress();
    }

    /**
     * Returns daily controls statistics grouped by product group.
     */
    public function getTotalDailyControlsStats(): array
    {
        $productGroups = DB::table('product_group')->pluck('name', 'id')->toArray();

        $stats = [];

        foreach ($productGroups as $groupId => $groupName) {
            $stats[$groupName] = [
                'over_time' => $this->dailyControlReporting->getDailyControlsOverTimeByGroup($groupId),
            ];
        }

        return $stats;
    }

    
    /**
     * Returns the overall statistics.
     */
    public function getOverAllStats(): array
    {
        return [
            'total_dailycontrols'           => $this->dailyControlReporting->getTotalDailyControlsProgress(),
            'average_dailycontrols' => $this->dailyControlReporting->getAverageDailyControlsRevenueValueProgress(),
            'average_expenses' => $this->dailyControlReporting->getAverageExpenses(),
            'average_leads_per_day' => $this->dailyControlReporting->getAverageLeadsPerDayValueProgress(),
            'average_cost_per_lead' => $this->dailyControlReporting->getAverageCostPerLeadValueProgress(),
            'average_calls_per_day' => $this->dailyControlReporting->getAverageCallsPerDayValueProgress(),
            'average_sales_per_day' => $this->dailyControlReporting->getAverageSalesPerDayValueProgress(),
        ];
    }
}