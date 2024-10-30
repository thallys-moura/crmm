<?php

namespace Webkul\Expenses\Repositories;

use Webkul\Core\Eloquent\Repository;

class ExpenseTypeRepository extends Repository
{
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Expenses\Models\ExpenseType';
    }

    /**
     * Cria um novo tipo de despesa.
     *
     * @param array $data
     * @return \Webkul\Expenses\Models\ExpenseType
     */
    public function create(array $data)
    {
        return parent::create($data);
    }

    /**
     * Atualiza um tipo de despesa existente.
     *
     * @param array $data
     * @param int $id
     * @return \Webkul\Expenses\Models\ExpenseType
     */
    public function update(array $data, $id)
    {
        return parent::update($data, $id);
    }

    /**
     * Remove um tipo de despesa pelo ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }
}