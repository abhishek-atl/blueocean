<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTherapistApplication extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^[+0-9\s\-\(\)]+$/', 'max:20'],
            'address' => ['required', 'string', 'max:1000'],
            'travel' => ['required', 'in:yes,no'],
            'fulltime' => ['required', 'in:fulltime,parttime,flexitime'],
            'favourite_massage_style' => ['required', 'string', 'max:2000'],
            'massage_love_reason' => ['required', 'string', 'max:3000'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx,rtf,txt', 'max:5120'],
            'photo' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
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
            'travel.required' => 'Please confirm whether you are happy to travel.',
            'fulltime.required' => 'Please select your preferred work pattern.',
            'favourite_massage_style.required' => 'Please tell us which massage styles you like most.',
            'massage_love_reason.required' => 'Please tell us what you love about giving massages and your experience.',
            'cv.required' => 'Please attach your CV.',
            'cv.mimes' => 'The CV must be a PDF, DOC, DOCX, RTF, or TXT file.',
            'cv.max' => 'The CV must not exceed 5MB.',
            'photo.required' => 'Please attach a recent photograph.',
            'photo.image' => 'The photograph must be a valid image file.',
            'photo.mimes' => 'The photograph must be a JPEG, JPG, PNG, or WEBP file.',
            'photo.max' => 'The photograph must not exceed 5MB.',
        ];
    }
}
