<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServicesController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where('section_key', 'services')
            ->where('section_type', 'services')
            ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'services',
                'section_type' => 'services',
                'title' => 'Explore Our Services',
                'description' => 'Quick access to important services and resources',
                'data' => [
                    'services' => [],
                ],
                'sort_order' => 12,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $services = data_get($data, 'services', []);

        return view('admin.homepage.services.index', [
            'section' => $section,
            'services' => $services,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable'],
            'services' => ['required', 'array', 'min:1'],
            'services.*.title' => ['required', 'string', 'max:255'],
            'services.*.icon' => ['required', 'string', 'max:500'],
            'services.*.bgColor' => ['required', 'string', 'max:50'],
            'services.*.textColor' => ['required', 'string', 'max:50'],
            'services.*.link' => ['required', 'string', 'max:255'],
        ]);

        $section = HomePageSection::where('section_key', 'services')
            ->where('section_type', 'services')
            ->firstOrFail();

        // Properly cast checkbox value to boolean
        $section->title = $validated['title'] ?? null;
        $section->description = $validated['description'] ?? null;
        $section->is_active = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);

        $data = $section->data ?? [];
        $data['services'] = $validated['services'];
        $section->data = $data;
        $section->save();
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        return redirect()->route('admin.homepage.services.index')
            ->with('success', 'Services section updated successfully.');
    }

    protected function clearCache(): void
    {
        // Clear homepage cache
        Cache::forget('homepage_v2_data');
        
        // Clear tagged cache if supported
        try {
            Cache::tags(['homepage', 'homepage_sections'])->flush();
        } catch (\Exception $e) {
            // Tags not supported by cache driver, that's okay
        }
        
        // Clear view cache
        \Artisan::call('view:clear');
    }
}
