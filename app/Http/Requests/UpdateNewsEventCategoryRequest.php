<?php

namespace App\Http\Requests;

use App\Models\NewsEventCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateNewsEventCategoryRequest extends FormRequest
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
        /** @var \App\Models\NewsEventCategory|string|int|null $category */
        $category = $this->route('news_category');
        $categoryId = $category instanceof NewsEventCategory ? $category->id : $category;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('news_event_categories', 'name')->ignore($categoryId)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('news_event_categories', 'slug')->ignore($categoryId)],
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
