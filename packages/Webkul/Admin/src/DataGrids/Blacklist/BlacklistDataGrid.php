<?php

namespace Webkul\Admin\DataGrids\Blacklist;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BlacklistDataGrid extends DataGrid
{
    /**
     * Prepara o query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('black_list')
            ->select(
                'black_list.id',
                'black_list.sale_date',
                'persons.name as person_name',
                'users.name as user_name',
                'sellers.name as seller_name',
                'black_list.billed',
                'black_list.observations',
                'black_list.client_observations',
                'quotes.shipping_address as shipping_address'
            )
            ->leftJoin('leads', 'black_list.lead_id', '=', 'leads.id')
            ->leftJoin('persons', 'black_list.person_id', '=', 'persons.id')
            ->leftJoin('lead_quotes', 'leads.id', '=', 'lead_quotes.lead_id') 
            ->leftJoin('quotes', 'lead_quotes.quote_id', '=', 'quotes.id')    
            ->leftJoin('users', 'black_list.user_id', '=', 'users.id')
            ->leftJoin('users as sellers', 'black_list.seller_id', '=', 'sellers.id');

        $this->setQueryBuilder($queryBuilder);

        // Filtros
        $this->addFilter('id', 'black_list.id');
        $this->addFilter('sale_date', 'black_list.sale_date');
        $this->addFilter('lead_name', 'leads.name');
        $this->addFilter('user_name', 'users.name');
        $this->addFilter('seller_name', 'sellers.name');
        $this->addFilter('billed', 'black_list.billed');

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
            'index'      => 'sale_date',
            'label'      => trans('admin::app.blacklist.index.datagrid.sale-date'),
            'type'       => 'date',
            'sortable'   => true,
            'filterable' => true,
        ]);
        
        $this->addColumn([
            'index'      => 'person_name',
            'label'      => trans('admin::app.blacklist.index.datagrid.person'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'shipping_address',
            'label'      => trans('admin::app.blacklist.index.datagrid.shipping-address'),
            'type'       => 'string',
            'sortable'   => false,
            'filterable' => false,
            'closure'    => function ($row) {
                $address = json_decode($row->shipping_address, true);
                if ($address) {
                    return implode(', ', [
                        $address['address'] ?? '',
                        $address['city'] ?? '',
                        $address['state'] ?? '',
                        $address['postcode'] ?? '',
                        $address['country'] ?? '',
                    ]);
                }
                return 'Endereço não disponível';
            },
        ]);

        $this->addColumn([
            'index'      => 'user_name',
            'label'      => trans('admin::app.blacklist.index.datagrid.user'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'seller_name',
            'label'      => trans('admin::app.blacklist.index.datagrid.seller'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'billed',
            'label'      => trans('admin::app.blacklist.index.datagrid.billed'),
            'type'       => 'boolean',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => $row->billed ? 'Yes' : 'No',
        ]);

        $this->addColumn([
            'index'      => 'observations',
            'label'      => trans('admin::app.blacklist.index.datagrid.observations'),
            'type'       => 'string',
            'sortable'   => false,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'client_observations',
            'label'      => trans('admin::app.blacklist.index.datagrid.client-observations'),
            'type'       => 'string',
            'sortable'   => false,
            'filterable' => false,
        ]);
    }

    /**
     * Prepara as ações no datagrid.
     */
    public function prepareActions(): void
    {
        // $this->addAction([
        //     'index'  => 'edit',
        //     'icon'   => 'icon-edit',
        //     'title'  => 'Edit',
        //     'method' => 'GET',
        //     'url'    => fn ($row) => route('admin.blacklist.edit', $row->id),
        // ]);

        $this->addAction([
            'index'  => 'delete',
            'icon'   => 'icon-delete',
            'title'  => 'Delete',
            'method' => 'DELETE',
            'url'    => fn ($row) => route('admin.blacklist.destroy', $row->id),
        ]);
    }

    /**
     * Prepara as ações em massa.
     */
    public function prepareMassActions(): void
    {
        $this->addMassAction([
            'icon'   => 'icon-delete',
            'title'  => 'Mass Delete',
            'method' => 'POST',
            'url'    => route('admin.blacklist.mass-destroy'),
        ]);
    }
}
