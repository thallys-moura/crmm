<?php

namespace Webkul\Quote\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['name']; // Defina os campos que podem ser preenchidos

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}