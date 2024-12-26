<?php

namespace Webkul\DailyControls\Repositories;

use Webkul\Core\Eloquent\Repository;

class SourceRepository extends Repository
{
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\DailyControls\Models\Source';
    }

    /**
     * Retorna uma lista de fontes disponíveis.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllSources()
    {
        return $this->all();
    }

    /**
     * Cria uma nova fonte.
     *
     * @param  array  $data
     * @return \Webkul\DailyControls\Models\Source
     */
    public function create(array $data)
    {
        return parent::create($data);
    }

    /**
     * Atualiza uma fonte existente.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\DailyControls\Models\Source
     */
    public function update(array $data, $id)
    {
        return parent::update($data, $id);
    }

    /**
     * Remove uma fonte pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }
}
