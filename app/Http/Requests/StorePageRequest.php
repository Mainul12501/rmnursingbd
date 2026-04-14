<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $pageTitle = trim((string) $this->input('page_title', ''));
        $slugInput = trim((string) $this->input('slug', ''));

        $this->merge([
            'page_title' => $pageTitle,
            'menu_title' => trim((string) $this->input('menu_title', '')),
            'slug' => $slugInput !== '' ? Str::slug($slugInput) : Str::slug($pageTitle),
            'status' => (int) $this->input('status', 0),
            'order' => (int) $this->input('order', 1),
        ]);
    }

    public function rules(): array
    {
        return [
            'page_title' => ['required', 'string', 'max:255'],
            'menu_title' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sub_images' => ['nullable', 'array'],
            'sub_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'page_content' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('pages', 'slug')],
            'status' => ['required', 'integer', 'in:0,1'],
            'order' => ['nullable', 'integer', 'min:0', 'max:127'],
            'form_mode' => ['nullable', 'string'],
            'page_id' => ['nullable', 'integer'],
        ];
    }
}
