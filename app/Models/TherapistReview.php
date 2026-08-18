<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TherapistReview extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'eval_punctuality' => 'integer',
        'eval_professionalism' => 'integer',
        'eval_communication' => 'integer',
        'eval_technique' => 'integer',
        'avg_evaluation' => 'integer',
        'active' => 'boolean',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
