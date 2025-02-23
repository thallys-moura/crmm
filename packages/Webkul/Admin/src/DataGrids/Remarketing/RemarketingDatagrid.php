<?php

namespace Webkul\Admin\DataGrids\Remarketing;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class RemarketingDatagrid extends DataGrid
{
    /**
     * Prepara o query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('remarketing')
            ->select(
                'remarketing.id',
                'remarketing.first_name',
                'remarketing.last_name',
                'remarketing.address',
                'remarketing.city',
                'remarketing.zipcode',
                'remarketing.bottle',
                'remarketing.product_id',
                'remarketing.user_id AS person_id',
                'products.name as product_name',
                'products.price as product_price',
                'remarketing.email as email',
                'remarketing.phone_number as phone_number',
                DB::raw("CONCAT(remarketing.first_name, ' ', remarketing.last_name) AS user_name"),
                DB::raw("CONCAT(remarketing.address, ', ', remarketing.zipcode) AS shipping_address"),
                'remarketing.created_at'
            )
            ->leftJoin('products', 'remarketing.product_id', '=', 'products.id')
            ->whereNull('remarketing.quote_id')
            ->whereNull('remarketing.lead_id');
        $this->setQueryBuilder($queryBuilder);

        // Filtros
        $this->addFilter('id', 'remarketing.id');
        $this->addFilter('user_name', DB::raw("CONCAT(remarketing.first_name, ' ', remarketing.last_name)"));
        $this->addFilter('product_name', 'products.name');

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
            'index'      => 'product_name',
            'label'      => 'Produto',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'user_name',
            'label'      => 'Cliente',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'bottle',
            'label'      => 'Quantidade',
            'type'       => 'integer',
            'sortable'   => true,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'product_price',
            'label'      => 'Preço Unitário',
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'shipping_address',
            'label'      => 'Endereço de Envio',
            'type'       => 'string',
            'sortable'   => false,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => 'Criado em',
            'type'       => 'date',
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
            'index'  => 'create',
            'icon'   => 'icon-quote',
            'title'  => 'Criar Venda',
            'method' => 'GET',
            'url'    => fn ($row) => route('admin.quotes.create', [
                'remarketing_id' => $row->id,
                'person'         => $row->first_name.' '.$row->last_name,
                'product_id'     => $row->product_id,
                'quantity'       => $row->bottle,
                'price'          => $row->product_price,
                'address'        => $row->address,
                'city'           => $row->city,
                'zipcode'        => $row->zipcode,
                'email'          => $row->email,
                'phone_number'   => $row->phone_number,
            ]),
        ]);

        $this->addAction([
            'index'  => 'delete',
            'icon'   => 'icon-delete',
            'title'  => 'Excluir',
            'method' => 'DELETE',
            'url'    => fn ($row) => route('admin.remarketing.delete', $row->id),
        ]);
    }

    /**
     * Prepara as ações em massa.
     */
    public function prepareMassActions(): void
    {
        $this->addMassAction([
            'icon'   => 'icon-delete',
            'title'  => 'Excluir em Massa',
            'method' => 'POST',
            'url'    => route('admin.remarketing.mass_destroy'),
        ]);
    }
}
