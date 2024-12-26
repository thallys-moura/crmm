<?php

namespace Webkul\DailyControls\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\DailyControls\Models\DailyControls;
use Webkul\Lead\Models\Lead;
use app\Models\User;
class Source extends Model
{
    /**
     * Tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'sources';

    /**
     * Campos preenchíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relacionamento: Source tem muitos DailyControls.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dailyControls()
    {
        return $this->hasMany(DailyControls::class);
    }
}