<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TherapistProfile extends Model
{
    protected $guarded = ['id'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset(config('custom.download.url') . config('custom.upload.therapist_path') . '/' . $value)
        );
    }
}
