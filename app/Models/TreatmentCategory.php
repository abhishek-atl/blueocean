<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreatmentCategory extends Model
{
    protected $guarded = ['id'];

    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'category_id');
    }
}
