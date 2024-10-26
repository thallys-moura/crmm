<?php

namespace Webkul\Reports\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /**
     * Define a tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'leads';

    /**
     * Definir as colunas que podem ser massivamente atribuídas.
     *
     * @var array
     */
    protected $fillable = [
        'lead_value',
        'billing_status_id',
        'payment_date',
        'created_at'
    ];

    /**
     * Definir relação muitos-para-muitos com Quotes.
     */
    public function quotes()
    {
        return $this->belongsToMany('Webkul\Reports\Models\Quote', 'lead_quotes', 'lead_id', 'quote_id');
    }
}