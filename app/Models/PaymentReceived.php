<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'payment_received';

    public function therapist()
    {
        return $this->belongsTo(User::class);
    }
}
