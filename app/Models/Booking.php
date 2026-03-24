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
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    protected function address(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->street_number . ' ' . $this->street_name . ' ' . $this->town . ' ' . $this->postcode
        );
    }
}
