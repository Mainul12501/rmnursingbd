<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeSliderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim((string) $this->input('title', '')),
            'content' => trim((string) $this->input('content', '')),
            'status' => (int) $this->input('status', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'integer', 'in:0,1'],
            'form_mode' => ['nullable', 'string'],
            'home_slider_id' => ['nullable', 'integer'],
        ];
    }
}
