<?php

namespace Webkul\Admin\DataGrids\Expense;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ExpenseDataGrid extends DataGrid
{
    /**
     * Prepara o query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('expenses')
        ->select('expenses.id', 'expenses.value', 'expenses.date', 'expenses.description', 'users.name as user', 'expense_types.name as type')
        ->leftJoin('users', 'expenses.user_id', '=', 'users.id')
        ->leftJoin('expense_types', 'expenses.type_id', '=', 'expense_types.id');

        $this->setQueryBuilder($queryBuilder);
        $this->addFilter('id', 'expenses.id');
        $this->addFilter('type', 'expense_types.name'); // Apontando para a tabela correta
        $this->addFilter('date', 'expenses.date');
        $this->addFilter('value', 'expenses.value');
        $this->addFilter('sales_person', 'users.name');

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
            'index'      => 'type',
            'label'      => 'Tipo',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'description',
            'label'      => 'Descrição',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'date',
            'label'      => 'Data',
            'type'       => 'date',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatDate($row->date),
        ]);

        $this->addColumn([
            'index'      => 'value',
            'label'      => 'Valor',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatBasePrice($row->value, 2),
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
            'url'    => fn ($row) => route('admin.expenses.edit', $row->id),
        ]);

        $this->addAction([
            'index'  => 'delete',
            'icon'   => 'icon-delete',
            'title'  => 'Excluir',
            'method' => 'DELETE',
            'url'    => fn ($row) => route('admin.expenses.delete', $row->id),
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
            'url'    => route('admin.expenses.mass_delete'),
        ]);
    }
}