<?php

namespace Webkul\Admin\DataGrids\DailyControls;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\DailyControls\Repositories\DailyControlsRepository;
use Webkul\DailyControls\Repositories\SourceRepository;
use Webkul\User\Repositories\UserRepository;


class DailyControlsDataGrid extends DataGrid
{   
    public function __construct(
        protected DailyControlsRepository $dailyControlsRepository,
        protected SourceRepository $sourceRepository,
    ) {
    }
    /**
     * Prepara o query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('daily_controls')
            ->select(
                'daily_controls.id',
                'daily_controls.date',
                'users.name as user',
                'daily_controls.sales',
                'daily_controls.calls_made',
                'daily_controls.leads_count',
                'daily_controls.daily_ad_spending',
                'daily_controls.total_revenue',
                'product_group.name as product_group',
                'sources.name as source',
            )
            ->leftJoin('users', 'daily_controls.user_id', '=', 'users.id')
            ->leftJoin('sources', 'daily_controls.source_id', '=', 'sources.id')
            ->leftJoin('product_group', 'daily_controls.product_group_id', '=', 'product_group.id');

        $this->setQueryBuilder($queryBuilder);

        $this->addFilter('id', 'daily_controls.id');
        $this->addFilter('date', 'daily_controls.date');
        $this->addFilter('user', 'daily_controls.user_id');
        $this->addFilter('sales', 'daily_controls.sales');
        $this->addFilter('calls_made', 'daily_controls.calls_made');
        $this->addFilter('leads_count', 'daily_controls.leads_count');
        $this->addFilter('daily_ad_spending', 'daily_controls.daily_ad_spending');
        $this->addFilter('total_revenue', 'daily_controls.total_revenue');
        $this->addFilter('source', 'sources.id');
        $this->addFilter('product_group', 'product_group.id');
            
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
            'searchable' => true,
            'closure'    => fn ($row) => $row->id, 
        ]);

        $this->addColumn([
            'index'      => 'date',
            'label'      => 'Data',
            'type'       => 'date',
            'sortable'   => true,
            'filterable' => true,
            'searchable' => true,
        ]);

        $this->addColumn([
            'index'      => 'user',
            'label'      => 'Usuário',
            'type'               => 'string',
            'searchable'         => true,
            'sortable'           => true,   
            'filterable'         => true,
            'filterable_type'    => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => UserRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'id',
                ],
            ],
        ]);

        $this->addColumn([
            'index'      => 'sales',
            'label'      => 'Vendas',
            'type'       => 'integer',
            'sortable'   => true,
            'filterable' => true,
            'searchable' => true,
        ]);

        $this->addColumn([
            'index'      => 'calls_made',
            'label'      => 'Ligações Feitas',
            'type'       => 'integer',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'leads_count',
            'label'      => 'Quantidade de Leads',
            'type'       => 'integer',
            'sortable'   => true,
            'filterable' => true,
            'searchable' => true,
        ]);

        $this->addColumn([
            'index'      => 'daily_ad_spending',
            'label'      => 'Gasto Diário com Anúncios',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatBasePrice($row->daily_ad_spending, 2),
            'searchable' => true,
        ]);

        $this->addColumn([
            'index'      => 'total_revenue',
            'label'      => 'Receita total',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatBasePrice($row->total_revenue, 2),
            'searchable' => true,
        ]);

        $this->addColumn([
            'index'      => 'source',
            'label'      => 'Fonte',
            'type'               => 'string',
            'searchable'         => true,
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'dropdown',
            'filterable_options' => $this->sourceRepository->getAllSources(['name as label', 'id as value'])->toArray(),
        ]);

        $this->addColumn([
            'index'      => 'product_group',
            'label'      => 'Grupo de Produto',
            'type'               => 'string',
            'searchable'         => true,
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'dropdown',
            'filterable_options' => $this->dailyControlsRepository->getProductGroups(['name as label', 'id as value'])->toArray(),
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
            'url'    => fn ($row) => route('admin.daily_controls.edit', $row->id),
        ]);

        $this->addAction([
            'index'  => 'delete',
            'icon'   => 'icon-delete',
            'title'  => 'Excluir',
            'method' => 'DELETE',
            'url'    => fn ($row) => route('admin.daily_controls.delete', $row->id),
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
            'url'    => route('admin.daily_controls.mass_delete'),
        ]);
    }
}
