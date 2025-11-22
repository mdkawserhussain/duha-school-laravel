<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreNavigationItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasAnyRole(['admin', 'editor']);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'route_name' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:navigation_items,id'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
            'is_external' => ['boolean'],
            'target_blank' => ['boolean'],
            'section' => ['nullable', 'string', 'max:50'],
        ];
    }
}
