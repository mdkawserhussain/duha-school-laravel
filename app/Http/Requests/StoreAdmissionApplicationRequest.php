<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdmissionApplicationRequest extends FormRequest
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
     * Field names here match what the public admission form actually posts
     * (resources/views/pages/admission.blade.php). The controller maps them
     * onto the database columns (parent_phone, parent_email, student_name...).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'child_name' => 'required|string|max:255',
            'child_dob' => 'required|date|before:today',
            'grade_applied' => 'required|string|max:50',
            'message' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'parent_name.required' => 'Parent/Guardian name is required.',
            'phone.required' => 'Contact phone number is required.',
            'email.required' => 'Contact email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'child_name.required' => 'Child/Student name is required.',
            'child_dob.required' => 'Date of birth is required.',
            'child_dob.before' => 'Date of birth must be in the past.',
            'grade_applied.required' => 'Grade applying for is required.',
        ];
    }
}
