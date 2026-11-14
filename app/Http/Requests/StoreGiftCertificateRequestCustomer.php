<?php

namespace App\Http\Requests;

class StoreGiftCertificateRequestCustomer extends SpamProtectedFormRequest
{
    protected function spamEmailFields(): array
    {
        return ['sender_email', 'recipient_email'];
    }

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
            'voucher_id' => 'required',
            'gift_amount' => 'required|numeric|min:20',
            'recipient_email' => 'required|email',
            'sender_email' => 'required|email',
            'recipient_name' => 'required',
            'sender_name' => 'required',
        ];
    }
}
