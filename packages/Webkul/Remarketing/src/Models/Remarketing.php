<?php

namespace Webkul\Remarketing\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Lead\Models\LeadProxy;
use Webkul\Quote\Models\QuoteProxy;
use Webkul\User\Models\UserProxy;

class Remarketing extends Model
{
    protected $table = 'remarketing';

    protected $fillable = ['title', 'description', 'lead_id', 'quote_id', 'user_id'];

    // Relacionamento com Lead
    public function lead()
    {
        return $this->belongsTo(LeadProxy::modelClass(), 'lead_id');
    }

    // Relacionamento com Quote
    public function quote()
    {
        return $this->belongsTo(QuoteProxy::modelClass(), 'quote_id');
    }

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass(), 'user_id');
    }
}
