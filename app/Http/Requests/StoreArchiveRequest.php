<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArchiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by controller/middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'creator' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'contributor' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:255'],
            'format' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:255'],
            'reach' => ['nullable', 'string', 'max:255'],
            'rights' => ['nullable', 'string', 'max:255'],
            'documents' => ['required', 'array', 'min:1'],
            'documents.*' => ['required', 'mimes:pdf', 'max:51200'],
        ];
    }
}
