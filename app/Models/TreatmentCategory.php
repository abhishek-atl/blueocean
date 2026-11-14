<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TreatmentCategory extends Model
{
    protected $guarded = ['id'];

    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'treatment_treatment_category', 'treatment_category_id', 'treatment_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset(config('custom.upload.url') . config('custom.upload.treatment_category_path') . '/' . $value)
        );
    }
}
