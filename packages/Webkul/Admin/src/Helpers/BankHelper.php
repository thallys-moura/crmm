<?php

namespace Webkul\Admin\Helpers;

use Carbon\Carbon;
use Webkul\Bank\Repositories\BankRepository;
use Webkul\Admin\Helpers\Reporting\Bank;

class BankHelper
{
    public function __construct(protected BankRepository $bankRepository, protected Bank $bankReporting)
    {
    }

    /**
     * Get the start date for the control period.
     *
     * @return \Carbon\Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->bankReporting->getStartDate();
    }

    /**
     * Get the end date for the control period.
     *
     * @return \Carbon\Carbon
     */
    public function getEndDate(): Carbon
    {
        return $this->bankReporting->getEndDate();
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

    /**
     * Calcula as estatísticas de receita (movimentações financeiras).
     */
    public function getRevenueStats(): array
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        $result = $this->bankRepository->getRevenueStats($startDate, $endDate);
        return $result;
    }

    /**
     * Calcula o saldo atual (Receitas - Despesas).
     */
    public function getBalanceStats(): array
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        return $this->bankRepository->getBalanceStats($startDate, $endDate);
    }
}
