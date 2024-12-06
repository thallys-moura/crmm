<?php

namespace Webkul\Bank\Repositories;

use Webkul\Core\Eloquent\Repository;

class BankRepository extends Repository
{
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Bank\Models\Bank'; // Ajuste para o modelo associado ao banco
    }

    /**
     * Cria ou atualiza um registro de banco.
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return \Webkul\Bank\Models\Bank
     */
    public function create(array $data)
    {
        $bank = parent::create($data);

        return $bank;
    }

    /**
     * Atualiza um registro de banco existente.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\Bank\Models\Bank
     */
    public function update(array $data, $id)
    {
        $bank = parent::update($data, $id);

        return $bank;
    }

    /**
     * Remove um registro de banco pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }
}
