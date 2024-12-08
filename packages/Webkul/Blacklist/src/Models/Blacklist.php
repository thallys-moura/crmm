<?php

namespace Webkul\Blacklist\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Contact\Models\Person;
use Webkul\Lead\Models\Lead;
use app\Models\User;

class Blacklist extends Model
{
    protected $table = 'black_list';

    protected $fillable = [
        'sale_date',           // Data da venda
        'lead_id',             // Lead
        'person_id',           // Pessoa
        'user_id',             // Usuário
        'observations',        // Observações
        'client_observations', // Observações do cliente
        'billed',              // Faturado
        'seller_id',           // Vendedor
    ];
    // Relationships
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}