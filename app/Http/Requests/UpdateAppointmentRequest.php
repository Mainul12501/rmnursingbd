<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'requested_user_id' => $this->filled('requested_user_id') ? (int) $this->input('requested_user_id') : null,
            'managed_user_id' => $this->filled('managed_user_id') ? (int) $this->input('managed_user_id') : null,
            'company_service_id' => $this->filled('company_service_id') ? (int) $this->input('company_service_id') : null,
            'name' => trim((string) $this->input('name', '')),
            'mobile' => trim((string) $this->input('mobile', '')),
            'email' => trim((string) $this->input('email', '')),
            'subject' => trim((string) $this->input('subject', '')),
            'message' => trim((string) $this->input('message', '')),
            'status' => trim((string) $this->input('status', 'pending')),
        ]);
    }

    public function rules(): array
    {
        return [
            'requested_user_id' => ['nullable', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(['pending', 'contacted', 'scheduled', 'rejected', 'solved'])],
            'managed_user_id' => ['nullable', 'integer', 'exists:users,id'],
            'company_service_id' => ['nullable', 'integer', 'exists:company_services,id'],
            'form_mode' => ['nullable', 'string'],
            'appointment_id' => ['nullable', 'integer'],
        ];
    }
}
