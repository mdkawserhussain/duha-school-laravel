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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|email|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_address' => 'required|string|max:500',
            'student_name' => 'required|string|max:255',
            'student_dob' => 'required|date|before:today',
            'student_gender' => 'required|in:male,female,other',
            'current_grade' => 'required|string|max:50',
            'applying_grade' => 'required|string|max:50',
            'previous_school' => 'nullable|string|max:255',
            'medical_conditions' => 'nullable|string|max:500',
            'additional_notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'parent_name.required' => 'Parent/Guardian name is required.',
            'parent_email.required' => 'Parent/Guardian email is required.',
            'parent_email.email' => 'Please enter a valid email address.',
            'parent_phone.required' => 'Parent/Guardian phone number is required.',
            'student_name.required' => 'Student name is required.',
            'student_dob.required' => 'Student date of birth is required.',
            'student_dob.before' => 'Date of birth must be in the past.',
            'student_gender.required' => 'Student gender is required.',
            'current_grade.required' => 'Current grade is required.',
            'applying_grade.required' => 'Applying grade is required.',
        ];
    }
}
