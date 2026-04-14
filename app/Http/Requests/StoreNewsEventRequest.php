<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreNewsEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $title = trim((string) $this->input('title', ''));
        $slugInput = trim((string) $this->input('slug', ''));

        $this->merge([
            'title' => $title,
            'slug' => $slugInput !== '' ? Str::slug($slugInput) : Str::slug($title),
            'status' => (int) $this->input('status', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'news_event_category_id' => ['required', 'integer', 'exists:news_event_categories,id'],
            'title' => ['required', 'string', 'max:255', Rule::unique('news_events', 'title')],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('news_events', 'slug')],
            'main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sub_images' => ['nullable', 'array'],
            'sub_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'main_content' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
            'form_mode' => ['nullable', 'string'],
            'event_id' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'news_event_category_id.required' => 'Please select a category.',
            'news_event_category_id.exists' => 'The selected category is invalid.',
            'title.required' => 'The news event title is required.',
            'title.unique' => 'This news event title already exists.',
            'slug.unique' => 'This slug already exists.',
            'main_image.image' => 'The main image must be an image file.',
            'main_image.mimes' => 'The main image must be jpg, jpeg, png, or webp.',
            'sub_images.*.image' => 'Each sub image must be an image file.',
            'sub_images.*.mimes' => 'Each sub image must be jpg, jpeg, png, or webp.',
            'status.required' => 'Please choose a status.',
        ];
    }
}
