<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where('section_key', 'news')
            ->where('section_type', 'news')
            ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'news',
                'section_type' => 'news',
                'title' => 'Recent News',
                'description' => 'Control news/notices section display settings',
                'button_text' => 'View All News',
                'button_link' => '/notices',
                'data' => [
                    'title_override' => null,
                    'items_count' => 6,
                    'layout_style' => 'grid',
                ],
                'sort_order' => 17,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $settings = [
            'title_override' => data_get($data, 'title_override'),
            'items_count' => data_get($data, 'items_count', 6),
            'layout_style' => data_get($data, 'layout_style', 'grid'),
        ];

        return view('admin.homepage.news.index', [
            'section' => $section,
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title_override' => ['nullable', 'string', 'max:255'],
            'items_count' => ['required', 'integer', 'min:1', 'max:20'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'layout_style' => ['required', 'string', 'in:grid,list,carousel'],
            'is_active' => ['nullable'],
        ]);

        $section = HomePageSection::where('section_key', 'news')
            ->where('section_type', 'news')
            ->firstOrFail();

        // Properly cast checkbox value to boolean
        $section->button_text = $validated['button_text'] ?? null;
        $section->button_link = $validated['button_link'] ?? null;
        $section->is_active = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);

        $data = $section->data ?? [];
        $data['title_override'] = $validated['title_override'];
        $data['items_count'] = $validated['items_count'];
        $data['layout_style'] = $validated['layout_style'];
        $section->data = $data;
        $section->save();
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        return redirect()->route('admin.homepage.news.index')
            ->with('success', 'News display settings updated successfully.');
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
