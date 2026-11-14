<?php

namespace App\Http\Requests;

use App\Services\FormSpamProtection;
use Illuminate\Foundation\Http\FormRequest;

abstract class SpamProtectedFormRequest extends FormRequest
{
    protected function spamEmailFields(): array
    {
        return ['email'];
    }

    protected function prepareForValidation(): void
    {
        app(FormSpamProtection::class)->normalizeEmails($this, $this->spamEmailFields());
    }

    public function withValidator($validator): void
    {
        // Check only on the server so browser validation does not reveal the trap.
        $validator->after(function ($validator) {
            app(FormSpamProtection::class)->checkHoneypot($this, $validator);
        });
    }
}
