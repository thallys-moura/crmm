<?php

namespace Webkul\Quote\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Attribute\Traits\CustomAttribute;
use Webkul\Contact\Models\PersonProxy;
use Webkul\Quote\Models\PaymentMethod;
use Webkul\Lead\Models\LeadProxy;
use Webkul\Lead\Models\Lead;
use Webkul\Quote\Contracts\Quote as QuoteContract;
use Webkul\User\Models\UserProxy;

class Quote extends Model implements QuoteContract
{
    use CustomAttribute;

    protected $table = 'quotes';

    protected $casts = [
        'billing_address'  => 'array',
        'shipping_address' => 'array',
        'expired_at'       => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'description',
        'billing_address',
        'shipping_address',
        'discount_percent',
        'discount_amount',
        'tax_amount',
        'adjustment_amount',
        'sub_total',
        'grand_total',
        'expired_at',
        'user_id',
        'person_id',
        'raca',
        'payment_method_id',
        'paymentMethod',
        'items'
    ];

    /**
     * Get the quote items record associated with the quote.
     */
    public function items()
    {
        return $this->hasMany(QuoteItemProxy::modelClass());
    }

    /**
     * Get the user that owns the quote.
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    /**
     * Get the person that owns the quote.
     */
    public function person()
    {
        return $this->belongsTo(PersonProxy::modelClass());
    }

    // Modelo Quote
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_quotes', 'quote_id', 'lead_id');
    }

    /**
     * The leads that belong to the quote.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
