<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistsHoliday extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function therapist()
    {
        return $this->belongsTo(User::class);
    }
}
