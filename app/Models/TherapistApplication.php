<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TherapistApplication extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'approved' => 'boolean',
        'therapy_kit_ids' => 'array',
    ];
}
