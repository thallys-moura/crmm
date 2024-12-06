<?php

namespace Webkul\Admin\DataGrids\Bank;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BankDataGrid extends DataGrid
{
    /**
     * Prepara o query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('banks')
            ->select('banks.id', 'banks.name', 'banks.account', 'banks.branch', 'banks.balance', 'users.name as user')
            ->leftJoin('users', 'banks.user_id', '=', 'users.id');

        $this->setQueryBuilder($queryBuilder);
        $this->addFilter('id', 'banks.id');
        $this->addFilter('name', 'banks.name');
        $this->addFilter('account', 'banks.account');
        $this->addFilter('branch', 'banks.branch');
        $this->addFilter('balance', 'banks.balance');
        $this->addFilter('user', 'users.name');

        return $queryBuilder;
    }

    /**
     * Prepara as colunas do datagrid.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => 'ID',
            'type'       => 'integer',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => 'Nome',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'account',
            'label'      => 'Conta',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'branch',
            'label'      => 'Agência',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'balance',
            'label'      => 'Saldo',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatBasePrice($row->balance, 2),
        ]);

        $this->addColumn([
            'index'      => 'user',
            'label'      => 'Responsável',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    /**
     * Prepara as ações no datagrid.
     */
    public function prepareActions(): void
    {
        $this->addAction([
            'index'  => 'edit',
            'icon'   => 'icon-edit',
            'title'  => 'Editar',
            'method' => 'GET',
            'url'    => fn ($row) => route('admin.bank.edit', $row->id),
        ]);

        $this->addAction([
            'index'  => 'delete',
            'icon'   => 'icon-delete',
            'title'  => 'Excluir',
            'method' => 'DELETE',
            'url'    => fn ($row) => route('admin.bank.delete', $row->id),
        ]);
    }

    /**
     * Prepara as ações em massa.
     */
    public function prepareMassActions(): void
    {
        $this->addMassAction([
            'icon'   => 'icon-delete',
            'title'  => 'Excluir em massa',
            'method' => 'POST',
            'url'    => route('admin.bank.mass_delete'),
        ]);
    }
}
