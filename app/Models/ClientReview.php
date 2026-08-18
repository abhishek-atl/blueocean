<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientReview extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'eval_respectful_behaviour' => 'integer',
        'eval_communication' => 'integer',
        'eval_booking_information_accuracy' => 'integer',
        'eval_treatment_space_suitability' => 'integer',
        'felt_safe' => 'boolean',
        'accept_future_booking' => 'boolean',
        'avg_evaluation' => 'decimal:1',
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
