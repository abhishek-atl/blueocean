<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_post_tag', 'post_id', 'post_tag_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => asset(config('custom.upload.url') . config('custom.upload.post_path') . '/' . $value)
        );
    }
}
