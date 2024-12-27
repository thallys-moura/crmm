<?php

namespace Webkul\Admin\DataGrids\Quote;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Illuminate\Support\Facades\Log;

class QuoteDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('quotes')
            ->addSelect(
                'quotes.id',
                'quotes.subject',
                'quotes.expired_at',
                'quotes.sub_total',
                'quotes.discount_amount',
                'quotes.tax_amount',
                'quotes.adjustment_amount',
                'quotes.grand_total',
                'billing_status.status',
                'leads.billing_status_id',
                'quotes.created_at',
                'users.id as user_id',
                'users.name as sales_person',
                'persons.id as person_id',
                'persons.name as person_name',
                'persons.emails as person_email',
                'quotes.expired_at as expired_quotes',
                'products.name as product',
                'payment_methods.name as payment_method'
            )
            ->leftJoin('users', 'quotes.user_id', '=', 'users.id')
            ->leftJoin('persons', 'quotes.person_id', '=', 'persons.id')
            ->leftJoin('lead_quotes', 'quotes.id', '=', 'lead_quotes.quote_id')
            ->leftJoin('leads', 'lead_quotes.lead_id', '=', 'leads.id')
            ->leftJoin('lead_products', 'lead_products.lead_id', '=', 'leads.id')
            ->leftJoin('quote_items', 'quote_items.quote_id', '=', 'quotes.id')
            ->leftJoin('products', 'products.id', '=', 'quote_items.product_id')
            ->leftJoin('billing_status', 'leads.billing_status_id', '=', 'billing_status.id')
            ->leftJoin('payment_methods', 'quotes.payment_method_id', '=', 'payment_methods.id');
    
        if ($userIds = bouncer()->getAuthorizedUserIds()) {
            $queryBuilder->whereIn('quotes.user_id', $userIds);
        }

        $this->addFilter('id', 'quotes.id');
        $this->addFilter('user', 'quotes.user_id');
        $this->addFilter('sales_person', 'users.name');
        $this->addFilter('person_name', 'persons.name');
        $this->addFilter('expired_at', 'quotes.expired_at');
        $this->addFilter('created_at', 'quotes.created_at');
        $this->addFilter('status', 'billing_status.status');
        $this->addFilter('product', 'product.name');

        if (request()->input('expired_quotes.in') == 1) {
            $this->addFilter('expired_quotes', DB::raw('DATEDIFF(NOW(), '.$tablePrefix.'quotes.expired_at) >= '.$tablePrefix.'NOW()'));
        } else {
            $this->addFilter('expired_quotes', DB::raw('DATEDIFF(NOW(), '.$tablePrefix.'quotes.expired_at) < '.$tablePrefix.'NOW()'));
        }

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('admin::app.quotes.index.datagrid.status'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                // Adicione a lógica condicional para o status
                if ($row->billing_status_id == 1) {
                    return '<span style="background-color: green; color: white; border-radius: 10px; padding: 3px 8px;">Pago</span>';
                } elseif ($row->billing_status_id == 2) {
                    return '<span style="background-color: #23af91; color: white; border-radius: 10px; padding: 2px 5px;">Pagou Parc.</span>';
                } elseif ($row->billing_status_id == 3) {
                    return '<span style="background-color: red; color: white; border-radius: 10px; padding: 2px 5px;">Não Pagou</span>';
                } elseif ($row->billing_status_id == 4) {
                    return '<span style="background-color: red; color: white; border-radius: 10px; padding: 2px 5px;">Cancelado</span>';
                } elseif ($row->billing_status_id == 5) {
                    return '<span style="background-color: yellow; color: black; border-radius: 10px; padding: 2px 5px;">Pendente</span>';                    
                } else {
                    return '<span style="background-color: gray; color: white; border-radius: 10px; padding: 2px 5px;">Valor inválido</span>';
                }
            }
        ]);

        $this->addColumn([
            'index'      => 'product',
            'label'      => trans('admin::app.quotes.index.datagrid.product'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'              => 'sales_person',
            'label'              => trans('admin::app.quotes.index.datagrid.sales-person'),
            'type'               => 'string',
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => \Webkul\User\Repositories\UserRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'name',
                ],
            ],
        ]);

        $this->addColumn([
            'index'              => 'person_name',
            'label'              => trans('admin::app.quotes.index.datagrid.person'),
            'type'               => 'string',
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => \Webkul\Contact\Repositories\PersonRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'name',
                ],
            ],
            'closure'    => function ($row) {
                $route = route('admin.leads.view', $row->person_id);

                return "<a class=\"text-brandColor transition-all hover:underline\" href='".$route."'>".$row->person_name.'</a>';
            },
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => trans('admin::app.quotes.index.datagrid.email'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                $emails = json_decode($row->person_email, true);
        
                // Verifica se o JSON é válido e contém o campo 'value'
                return isset($emails[0]['value']) ? $emails[0]['value'] : 'N/A';
            },
        ]);
        

        $this->addColumn([
            'index'      => 'payment_method',
            'label'      => trans('admin::app.quotes.index.datagrid.payment_method'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
            'closure'    => fn ($row) => $row->payment_method, 
        ]);

        $this->addColumn([
            'index'      => 'discount_amount',
            'label'      => trans('admin::app.quotes.index.datagrid.discount'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatBasePrice($row->discount_amount, 2),
        ]);

        $this->addColumn([
            'index'      => 'grand_total',
            'label'      => trans('admin::app.quotes.index.datagrid.grand-total'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatBasePrice($row->grand_total, 2),
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.quotes.index.datagrid.created-at'),
            'type'       => 'date',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => fn ($row) => core()->formatDate($row->created_at),
        ]);
    }

    /**
     * Prepare actions.
     */
    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('quotes.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('admin::app.quotes.index.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.quotes.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('quotes.print')) {
            $this->addAction([
                'index'  => 'print',
                'icon'   => 'icon-print',
                'title'  => trans('admin::app.quotes.index.datagrid.print'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.quotes.print', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('quotes.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('admin::app.quotes.index.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => route('admin.quotes.delete', $row->id),
            ]);
        }
    }

    /**
     * Prepare mass actions.
     */
    public function prepareMassActions(): void
    {
        $this->addMassAction([
            'icon'   => 'icon-delete',
            'title'  => trans('admin::app.quotes.index.datagrid.delete'),
            'method' => 'POST',
            'url'    => route('admin.quotes.mass_delete'),
        ]);

        $this->addMassAction([
            'icon'   => 'icon-delete',
            'title'  => trans('admin::app.quotes.index.datagrid.delete'),
            'method' => 'POST',
            'url'    => route('admin.quotes.mass_delete'),
        ]);
    }
}
