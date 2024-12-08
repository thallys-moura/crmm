<?php

namespace Webkul\Blacklist\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\User\Models\UserProxy;

class BlacklistRepository extends Repository
{
    /**
     * Especifica o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Blacklist\Models\BlackList';
    }

    /**
     * Cria ou atualiza um registro na Black List.
     *
     * @param  array  $data
     * @return \Webkul\Blacklist\Models\Blacklist
     */
    public function create(array $data)
    {
        $blackList = parent::create($data);

        return $blackList;
    }

    /**
     * Atualiza um registro existente na Black List.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \Webkul\Blacklist\Models\Blacklist
     */
    public function update(array $data, $id)
    {
        $blackList = parent::update($data, $id);

        return $blackList;
    }

    /**
     * Remove um registro da Black List pelo ID.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete($id)
    {
        return parent::delete($id);
    }

    /**
     * Busca registros por lead.
     *
     * @param  int  $leadId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByLead($leadId)
    {
        return $this->model->where('lead_id', $leadId)->get();
    }

    /**
     * Busca registros pelo usuário associado.
     *
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUser($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * Busca registros pelo vendedor.
     *
     * @param  int  $sellerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBySeller($sellerId)
    {
        return $this->model->where('seller_id', $sellerId)->get();
    }

}
