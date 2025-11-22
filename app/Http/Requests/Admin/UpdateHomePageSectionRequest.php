<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHomePageSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'editor']);
    }

    public function rules(): array
    {
        $sectionId = $this->route('homepage-section')->id ?? $this->route('homepage-section');

        return [
            'section_key' => ['required', 'string', 'max:255', Rule::unique('home_page_sections', 'section_key')->ignore($sectionId)],
            'section_type' => ['required', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'data' => ['nullable', 'array'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'background_image' => ['nullable', 'image', 'max:5120'],
            'video_poster' => ['nullable', 'image', 'max:5120'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Handle JSON data field if it's a string
        if ($this->has('data') && is_string($this->data)) {
            $decoded = json_decode($this->data, true);
            $this->merge(['data' => $decoded !== null ? $decoded : []]);
        }
    }
}
