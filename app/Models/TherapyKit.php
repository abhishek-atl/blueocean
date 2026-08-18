<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TherapyKit extends Model
{
    public const TYPE_EQUIPMENT = 'equipment';

    public const TYPE_PRODUCT = 'product';

    protected $table = 'therapy_kit';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'active' => 'boolean',
        ];
    }

    public function therapists()
    {
        return $this->belongsToMany(
            User::class,
            'therapist_therapy_kit',
            'therapy_kit_id',
            'therapist_id'
        )->withTimestamps();
    }
}
