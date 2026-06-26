<?php

namespace App\Http\Requests\Auth;

use App\Rules\Exists;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'mobile' => 'required',
            'email' => ['required', 'email', new Exists],
            'street_no' => 'required',
            'street_name' => 'required',
            'town' => 'required',
            'postcode' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.' . Exists::class => 'Email already registered'
        ];
    }
}
