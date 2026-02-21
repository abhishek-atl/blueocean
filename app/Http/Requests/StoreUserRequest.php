<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
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
        $userId = $this->input('id');

        return [
            // User table fields
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                $userId ? 'unique:users,email,' . $userId : 'unique:users,email',
            ],
            'password' => [
                $userId ? 'nullable' : 'required',
                'string',
                'min:6'
            ],

            // User Profile table fields
            'mobile' => ['required', 'string', 'regex:/^[+0-9\s\-\(\)]+$/', 'max:20'],
            'birthday' => ['required', 'date_format:d/m/Y', 'before:today'],
            'flat_no' => ['required', 'string', 'max:255'],
            'street_no' => ['required', 'string', 'max:255'],
            'street_name' => ['required', 'string', 'max:255'],
            'town' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],

            // File upload
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Status
            'active' => ['required', 'in:0,1'],
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
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name must not exceed 255 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.max' => 'Last name must not exceed 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number format is invalid.',
            'mobile.max' => 'Mobile number must not exceed 20 characters.',
            'birthday.required' => 'Birthday is required.',
            'birthday.date_format' => 'Birthday must be a valid date (YYYY-MM-DD).',
            'birthday.before' => 'Birthday must be in the past.',
            'flat_no.required' => 'Flat number is required.',
            'street_no.required' => 'Street number is required.',
            'street_name.required' => 'Street name is required.',
            'town.required' => 'Town is required.',
            'postcode.required' => 'Postcode is required.',
            'image.image' => 'The image must be a valid image file.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, or GIF file.',
            'image.max' => 'The image must not exceed 2MB.',
            'active.required' => 'Active status is required.',
            'active.in' => 'Active status must be either Yes or No.',
        ];
    }
}
