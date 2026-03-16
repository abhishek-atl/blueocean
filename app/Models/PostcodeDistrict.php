<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostcodeDistrict extends Model
{
    protected $guarded = ['id'];

    public function postcodes()
    {
        return $this->hasMany(Postcode::class, 'district_id');
    }
}
