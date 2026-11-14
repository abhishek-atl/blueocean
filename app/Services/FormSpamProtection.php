<?php

namespace App\Services;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class FormSpamProtection
{
    public function limit(Request $request): Limit
    {
        return Limit::perMinutes(10, 3)->by($request->ip());
    }

    public function normalizeEmails(Request $request, array $fields): void
    {
        foreach ($fields as $field) {
            if (is_string($request->input($field))) {
                $request->merge([$field => strtolower(trim($request->input($field)))]);
            }
        }
    }

    public function checkHoneypot(Request $request, $validator): void
    {
        if ($request->filled('website')) {
            $validator->errors()->add('application', 'Unable to submit this form. Please try again.');
        }
    }

    public function submit(string $scope, string $email, string $emailField, Builder $query, callable $submit): mixed
    {
        $lock = Cache::lock($scope . ':' . hash('sha256', $email), 120);

        if (! $lock->get()) {
            throw ValidationException::withMessages([
                $emailField => 'A submission for this email is already being processed. Please try again later.',
            ]);
        }

        try {
            if ($query->whereRaw('LOWER(' . $emailField . ') = ?', [$email])
                ->where('created_at', '>=', now()->subMinutes(30))->exists()) {
                throw ValidationException::withMessages([
                    $emailField => 'We have already received a submission for this email. Please wait 30 minutes before submitting again.',
                ]);
            }

            return $submit();
        } finally {
            $lock->release();
        }
    }
}
