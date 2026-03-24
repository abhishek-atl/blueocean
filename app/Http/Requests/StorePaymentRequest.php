<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'booking_id' => 'required|integer|exists:bookings,id',
            'amount' => 'required|integer|min:0',
            'gift_discount_amount' => 'nullable|numeric|min:0',
            'refund_amount' => 'nullable|integer|min:0',
            'payment_type' => 'required|in:cash,credit,stripe,gift_voucher',
            'status' => 'required|in:pending,completed,failed,refunded',
            'charge_id' => 'nullable|string|max:150',
        ];
    }
}
