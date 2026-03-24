<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'user_id' => 'nullable|integer|exists:users,id',
            'therapist_id' => 'required|integer|exists:users,id',
            'treatment_id' => 'required|integer|exists:treatments,id',
            'appointment_start' => 'required|date_format:' . config('custom.format.date_time'),
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:50',
            'phone' => 'required|string|max:14',
            'postcode' => 'required|string|max:50',
            'flat_no' => 'nullable|string|max:50',
            'street_number' => 'required|string|max:50',
            'street_name' => 'nullable|string|max:50',
            'town' => 'required|string|max:100',
            'comments' => 'nullable|string',
            'duration' => 'required|integer',
            'extra_duration' => 'nullable|integer|min:0',
            'amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'travel_supp' => 'nullable|numeric|min:0',
            'payable_amount' => 'required|numeric|min:0',
            'fee_platform' => 'required|numeric|min:0',
            'fee_therapist' => 'required|numeric|min:0',
        ];
    }
}
