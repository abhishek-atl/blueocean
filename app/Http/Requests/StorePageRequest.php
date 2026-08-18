<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer', 'exists:pages,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages', 'slug')->ignore($this->input('id')),
            ],
            'author' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'image_title' => ['nullable', 'string', 'max:255'],
            'page_meta_title' => ['nullable', 'string', 'max:255'],
            'page_meta_description' => ['nullable', 'string'],
            'page_extra_meta_tags' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
        ];
    }
}
