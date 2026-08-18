<?php

namespace App\Http\Requests;

use App\Models\TherapyKit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTherapyKitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->boolean('active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', 'exists:therapy_kit,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'type' => [
                'required',
                Rule::in([TherapyKit::TYPE_EQUIPMENT, TherapyKit::TYPE_PRODUCT]),
            ],
            'active' => ['required', 'boolean'],
        ];
    }
}
