<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateNoticeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'editor']);
    }

    public function rules(): array
    {
        $noticeId = $this->route('notice'); // Now it's the ID directly

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('notices', 'slug')->ignore($noticeId), 'regex:/^[a-z0-9_-]+$/'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'is_important' => ['boolean'],
            'is_published' => ['boolean'],
            'published_at' => ['required', 'date'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('slug') && $this->has('title')) {
            $this->merge(['slug' => Str::slug($this->title)]);
        }
    }
}
