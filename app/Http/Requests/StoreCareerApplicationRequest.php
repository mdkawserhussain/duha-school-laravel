<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCareerApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'position_applied' => 'required|string|max:255',
            'cover_letter' => 'required|string|max:2000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
            'experience' => 'nullable|string|max:1000',
            'education' => 'nullable|string|max:1000',
            'skills' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone number is required.',
            'position_applied.required' => 'Position applied for is required.',
            'cover_letter.required' => 'Cover letter is required.',
            'resume.required' => 'Resume is required.',
            'resume.file' => 'Resume must be a valid file.',
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'Resume must not exceed 5MB in size.',
        ];
    }
}
