<?php

namespace Webkul\Expenses\Repositories;

use Webkul\Core\Eloquent\Repository;

class ExpenseRepository extends Repository
{
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Expenses\Models\Expense';
    }

    /**
     * Cria ou atualiza uma despesa.
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return \Webkul\Expenses\Models\Expense
     */
    public function create(array $data)
    {

        $expense = parent::create($data);

        return $expense;
    }

    /**
     * Atualiza uma despesa existente.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\Expenses\Models\Expense
     */
    public function update(array $data, $id)
    {
        $expense = parent::update($data, $id);

        return $expense;
    }

    /**
     * Remove uma despesa pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }
}