<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(TreatmentCategory::class, 'treatment_treatment_category', 'treatment_id', 'treatment_category_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset(config('custom.upload.url') . config('custom.upload.treatment_path') . '/' . $value)
        );
    }
}
