<?php

namespace Webkul\Expenses\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\UserProxy;

class Expense extends Model
{
    protected $fillable = [
        'type_id', 'user_id', 'value', 'date', 'description', 'observation'
    ];

    /**
     * Define o relacionamento com ExpenseType.
     */
    public function type()
    {
        return $this->belongsTo(ExpenseType::class, 'type_id');
    }

    /**
     * Define o relacionamento com User.
     * Cada despesa pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::class, 'user_id');
    }
}