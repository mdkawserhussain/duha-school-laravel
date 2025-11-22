<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'editor']);
    }

    public function rules(): array
    {
        $eventId = $this->route('event'); // Now it's the ID directly

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($eventId), 'regex:/^[a-z0-9_-]+$/'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date', 'after:start_at'],
            'category' => ['nullable', 'string', 'max:100'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published,archived'],
            'published_at' => ['required', 'date'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:5120'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Auto-generate slug if not provided and title changed
        if (!$this->has('slug') && $this->has('title')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }

        // Set is_published based on status
        if ($this->has('status')) {
            $this->merge([
                'is_published' => $this->status === 'published',
            ]);
        }
    }
}
