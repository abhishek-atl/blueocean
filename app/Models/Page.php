<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = ['id'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value
                ? asset(config('custom.upload.url').config('custom.upload.page_path').'/'.$value)
                : null
        );
    }
}
