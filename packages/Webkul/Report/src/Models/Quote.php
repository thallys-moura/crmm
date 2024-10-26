<?php

namespace Webkul\Reports\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    protected $fillable = [
        'payment_method_id',
        'total_value'
    ];

    /**
     * Definir relação muitos-para-muitos com Leads.
     */
    public function leads()
    {
        return $this->belongsToMany('Webkul\Reports\Models\Lead', 'lead_quotes', 'quote_id', 'lead_id');
    }
}