<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public function tariffPlans()
    {
        return $this->belongsToMany(TariffPlan::class, 'promocode_tariff_plan');
    }
}
