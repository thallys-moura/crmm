<?php

namespace Webkul\Expenses\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = ['name'];

    /**
     * Define o relacionamento com Expense.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'type_id');
    }
}