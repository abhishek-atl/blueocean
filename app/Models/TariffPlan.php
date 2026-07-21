<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TariffPlan extends Model
{
    protected $guarded = ['id'];

    public function promocodes()
    {
        return $this->belongsToMany(Promocode::class, 'promocode_tariff_plan');
    }
}
