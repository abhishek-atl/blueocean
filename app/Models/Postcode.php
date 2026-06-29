<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postcode extends Model
{
    protected $guarded = ['id'];

    public function district()
    {
        return $this->belongsTo(PostcodeDistrict::class, 'district_id');
    }

    public function zone()
    {
        //return $this->hasOne(PostcodeZoneShortcut::class, 'postcodes_id', 'id');
    }
}
