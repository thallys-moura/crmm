<?php

namespace Webkul\DailyControls\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\DailyControls\Repositories\SourceRepository;
use Webkul\DailyControls\Contracts\DailyControls;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;

class DailyControlsRepository extends Repository
{   


    public function __construct(SourceRepository $sourceRepository,
        Container $container
    )
    {
        $this->sourceRepository = $sourceRepository;

        parent::__construct($container);
    }

    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return \Webkul\DailyControls\Models\DailyControls::class;
    }    
    
    /**
     * Create.
     *
     * @return \Webkul\DailyControls\Contracts\DailyControls
     */
    public function create(array $data)
    {
        try {
            // Tenta criar o registro utilizando o método da classe pai
            $dailyControl = parent::create($data);
    
            return $dailyControl;
        } catch (\Exception $e) {
            // Relança a exceção para depuração posterior
            throw new \Exception('Erro ao criar Controle Diário: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Atualiza um registro de controle diário existente.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\DailyControls\Models\DailyControls
     */
    public function update(array $data, $id)
    {
        $dailyControl = parent::update($data, $id);

        return $dailyControl;
    }

    /**
     * Remove um registro de controle diário pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    /**
     * Obtém todas as fontes disponíveis.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSources()
    {
        return $this->sourceRepository->all();
    }

    /**
     * Obtém registros agrupados por data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDailyGrouped()
    {
        return $this->model->selectRaw('date, sum(sales) as total_sales, sum(calls_made) as total_calls, sum(leads_count) as total_leads, sum(daily_ad_spending) as total_spending, sum(total_revenue) as total_revenue')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getDailyGroupedByProductGroup()
    {
        return $this->model->selectRaw('product_group.name as product_group_name, date, sum(sales) as total_sales, sum(calls_made) as total_calls, sum(leads_count) as total_leads, sum(daily_ad_spending) as total_spending, sum(total_revenue) as total_revenue')
            ->join('product_group', 'daily_controls.product_group_id', '=', 'product_group.id')
            ->groupBy('product_group_name', 'date')
            ->orderBy('date', 'desc')
            ->get();
    }
    
    public function getProductGroups()
    {
        return DB::table('product_group')
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
    }

}