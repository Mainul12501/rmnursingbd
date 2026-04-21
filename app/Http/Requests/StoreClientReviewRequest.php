<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreClientReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $pubDate = trim((string) $this->input('pub_date', ''));
        $normalizedPubDate = null;

        if ($pubDate !== '') {
            try {
                $normalizedPubDate = Carbon::parse($pubDate)->format('Y-m-d');
            } catch (\Throwable $e) {
                $normalizedPubDate = $pubDate;
            }
        }

        $this->merge([
            'client_name' => trim((string) $this->input('client_name', '')),
            'rating' => (string) $this->input('rating', ''),
            'content' => trim((string) $this->input('content', '')),
            'pub_date' => $normalizedPubDate,
            'status' => (int) $this->input('status', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'client_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'rating' => ['required', 'string', 'in:1,2,3,4,5'],
            'content' => ['required', 'string'],
            'pub_date' => ['nullable', 'date'],
            'status' => ['required', 'integer', 'in:0,1'],
            'form_mode' => ['nullable', 'string'],
            'client_review_id' => ['nullable', 'integer'],
        ];
    }
}
