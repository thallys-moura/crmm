<?php

namespace Webkul\Remarketing\Repositories;

use Webkul\Core\Eloquent\Repository;

class RemarketingRepository extends Repository
{
    /**
     * Define o modelo associado ao repositório.
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Remarketing\Models\Remarketing';
    }
}