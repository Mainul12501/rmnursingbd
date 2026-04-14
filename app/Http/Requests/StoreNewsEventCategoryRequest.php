<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreNewsEventCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $name = trim((string) $this->input('name', ''));
        $slugInput = trim((string) $this->input('slug', ''));

        $this->merge([
            'name' => $name,
            'slug' => Str::slug($slugInput !== '' ? $slugInput : $name),
            'status' => (int) $this->input('status', 1),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('news_event_categories', 'name')],
            'slug' => ['required', 'string', 'max:255', Rule::unique('news_event_categories', 'slug')],
            'status' => ['required', 'integer', 'in:0,1'],
            'form_mode' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.unique' => 'This category name already exists.',
            'slug.required' => 'The category slug is required.',
            'slug.unique' => 'This category slug already exists.',
            'status.required' => 'Please select a status.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
}
