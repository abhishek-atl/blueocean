<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Exists implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = User::where($attribute, $value)->first();
        if (($exists && request('user_id') && $exists->id != request('user_id')) || ($exists && !request('user_id'))) {
            $fail('Email already registered. Please log in or use a different email.');
        }
    }
}
