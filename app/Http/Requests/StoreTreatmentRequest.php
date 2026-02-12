<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'summary' => 'nullable|string|max:500',
            'cta_text_visible' => 'nullable|boolean',
            'cta_text' => 'nullable|string',
            'active' => 'nullable|boolean',
            'on_treatment_page' => 'nullable|boolean',
            'cta_button_visible' => 'nullable|boolean',
            'cta_button_text' => 'nullable|string|max:255',
            'cta_button_url' => 'nullable|url|max:255',
            'page_meta_title' => 'nullable|string',
            'page_meta_tag' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'extra_meta_tags' => 'nullable|string',
            'show_progress_bar' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
