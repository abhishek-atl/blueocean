<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostcodeZone extends Model
{
    protected $guarded = ['id'];

    public function postcodes()
    {
        return $this->belongsToMany(Postcode::class, 'postcode_zones_postcodes', 'postcode_zone_id', 'postcode_id');
    }
}
