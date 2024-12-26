<?php

namespace Webkul\DailyControls\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\User\Models\UserProxy;

use Webkul\DailyControls\Contracts\DailyControls as DailyControlsContract;

class DailyControls extends Model 

{
    /**
     * Tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'daily_controls';

    /**
     * Campos preenchíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'sales',
        'calls_made',
        'leads_count',
        'daily_ad_spending',
        'total_revenue',
        'source_id',
        'created_at',
        'product_group_id'
    ];

    /**
     * Relacionamento: DailyControl pertence a um usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass(), 'user_id');
    }

    /**
     * Relacionamento: DailyControl pertence a uma fonte (source).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

}
