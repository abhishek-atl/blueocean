<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

    protected $table = 'bookings';

    protected $casts = [
        'booking_datetime' => 'datetime',
        'appointment_start' => 'datetime',
        'appointment_finish' => 'datetime',
        'cancellation_requested_at' => 'datetime',
        'paid_by_therapist' => 'boolean',
        'therapist_conf_sms' => 'boolean',
        'is_extension_paid' => 'boolean',
        'therapy_kit_amount' => 'decimal:2',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function therapyKits()
    {
        return $this->belongsToMany(TherapyKit::class, 'booking_therapy_kit')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function therapistReview()
    {
        return $this->hasOne(TherapistReview::class);
    }

    public function clientReview()
    {
        return $this->hasOne(ClientReview::class);
    }

    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->street_number . ' ' . $this->street_name . ' ' . $this->town . ' ' . $this->postcode
        );
    }
}
