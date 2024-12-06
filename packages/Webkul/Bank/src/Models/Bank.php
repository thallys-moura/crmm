<?php 

namespace Webkul\Bank\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\UserProxy;

class Bank extends Model
{
    protected $fillable = [
        'name', 'account', 'branch', 'balance', 'user_id', 'observation'
    ];

    /**
     * Define o relacionamento com User.
     * Cada registro de banco pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::class, 'user_id');
    }
}