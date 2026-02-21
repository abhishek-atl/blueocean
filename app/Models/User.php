<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const TYPE_ADMIN = 'Admin';
    const TYPE_THERAPIST = 'Therapist';
    const TYPE_CUSTOMER = 'Customer';

    public function user_profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function therapist_profile()
    {
        return $this->hasOne(TherapistProfile::class);
    }

    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'therapists_treatments', 'user_id', 'treatment_id');
    }

    public function postcodes()
    {
        return $this->belongsToMany(Postcode::class, 'therapists_postcodes', 'user_id', 'postcode_id');
    }

    public function schedule()
    {
        return $this->hasOne(TherapistSchedule::class);
    }

    public function holidays()
    {
        return $this->hasMany(TherapistHoliday::class);
    }

    public function active()
    {
        return $this->active;
    }

}
