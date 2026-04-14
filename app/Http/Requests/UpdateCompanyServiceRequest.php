<?php

namespace App\Http\Requests;

use App\Models\CompanyService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCompanyServiceRequest extends FormRequest
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
            'content_title' => trim((string) $this->input('content_title', '')),
            'slug' => $slugInput !== '' ? Str::slug($slugInput) : Str::slug($name),
            'status' => (int) $this->input('status', 0),
        ]);
    }

    public function rules(): array
    {
        /** @var \App\Models\CompanyService|string|int|null $companyService */
        $companyService = $this->route('company_service');
        $serviceId = $companyService instanceof CompanyService ? $companyService->id : $companyService;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('company_services', 'name')->ignore($serviceId)],
            'content_title' => ['nullable', 'string', 'max:255'],
            'page_content' => ['nullable', 'string'],
            'page_main_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'service_menu_type' => ['required', 'in:main,sub,both'],
            'status' => ['required', 'integer', 'in:0,1'],
            'page_sub_images' => ['nullable', 'array'],
            'page_sub_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('company_services', 'slug')->ignore($serviceId)],
            'form_mode' => ['nullable', 'string'],
            'service_id' => ['nullable', 'integer'],
        ];
    }
}
