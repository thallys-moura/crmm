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
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('remarketing')
            ->select(
                'remarketing.id',
                'products.name as product_name',
                'users.name as user_name',
                'quotes.shipping_address',
                'remarketing.created_at'
            )
            ->leftJoin('quotes', 'remarketing.quote_id', '=', 'quotes.id')
            ->leftJoin('quote_items', 'quotes.id', '=', 'quote_items.quote_id')
            ->leftJoin('products', 'quote_items.product_id', '=', 'products.id')
            ->leftJoin('users', 'quotes.user_id', '=', 'users.id');

        $this->setQueryBuilder($queryBuilder);

        // Filtros
        $this->addFilter('id', 'remarketing.id');
        $this->addFilter('product_name', 'products.name');
        $this->addFilter('user_name', 'users.name');

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
            'index'      => 'shipping_address',
            'label'      => 'Endereço de Envio',
            'type'       => 'string',
            'sortable'   => false,
            'filterable' => false,
            'closure'    => function ($row) {
                $address = json_decode($row->shipping_address, true);
                if ($address) {
                    return implode(', ', [
                        $address['address1'] ?? '',
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
            'index'  => 'edit',
            'icon'   => 'icon-edit',
            'title'  => 'Editar',
            'method' => 'GET',
            'url'    => fn ($row) => route('admin.remarketing.edit', $row->id),
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
