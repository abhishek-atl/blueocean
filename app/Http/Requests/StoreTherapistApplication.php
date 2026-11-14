<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTherapistApplication extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (is_string($this->input('email'))) {
            $this->merge(['email' => strtolower(trim($this->input('email')))]);
        }
    }

    public function withValidator($validator): void
    {
        // Keep this check server-side so browser validation does not reveal the trap.
        $validator->after(function ($validator) {
            if ($this->filled('website')) {
                $validator->errors()->add('application', 'Unable to submit this application. Please try again.');
            }
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^[+0-9\s\-\(\)]+$/', 'max:20'],
            'therapy_kits' => ['nullable', 'array'],
            'therapy_kits.*' => ['integer', 'distinct', 'exists:therapy_kit,id,active,1'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'mobile.regex' => 'Mobile number format is invalid.',
        ];
    }
}
