<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsTickerController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where('section_key', 'news_ticker')
            ->where('section_type', 'news_ticker')
            ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'news_ticker',
                'section_type' => 'news_ticker',
                'title' => 'News Ticker',
                'description' => 'Control news ticker display settings',
                'data' => [
                    'is_enabled' => true,
                    'items_count' => 10,
                    'show_featured_only' => false,
                    'animation_speed' => 40,
                ],
                'sort_order' => 4,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $settings = [
            'is_enabled' => data_get($data, 'is_enabled', true),
            'items_count' => data_get($data, 'items_count', 10),
            'show_featured_only' => data_get($data, 'show_featured_only', false),
            'animation_speed' => data_get($data, 'animation_speed', 40),
            'is_active' => $section->is_active,
        ];

        return view('admin.homepage.news-ticker.index', [
            'section' => $section,
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'is_enabled' => ['nullable'],
            'items_count' => ['required', 'integer', 'min:1', 'max:50'],
            'show_featured_only' => ['nullable'],
            'animation_speed' => ['required', 'integer', 'min:10', 'max:120'],
            'is_active' => ['nullable'],
        ]);

        $section = HomePageSection::where('section_key', 'news_ticker')
            ->where('section_type', 'news_ticker')
            ->firstOrFail();

        // Convert checkbox values to proper booleans
        // Checkboxes send "1" when checked, nothing when unchecked
        $data = $section->data ?? [];
        $data['is_enabled'] = $request->has('is_enabled') && $request->input('is_enabled') == '1';
        $data['items_count'] = (int) $validated['items_count'];
        $data['show_featured_only'] = $request->has('show_featured_only') && $request->input('show_featured_only') == '1';
        $data['animation_speed'] = (int) $validated['animation_speed'];
        
        $section->data = $data;
        $section->is_active = $request->has('is_active') && $request->input('is_active') == '1';
        
        // Save the section (this will trigger the observer to clear cache)
        $section->save();
        
        // Refresh the model to ensure we have the latest data
        $section->refresh();
        
        // Double-check: Clear cache explicitly to ensure it's cleared
        // The observer should handle this, but we'll do it here too for safety
        $this->clearCache();
        
        // Log for debugging (can be removed in production)
        \Log::info('News Ticker updated', [
            'items_count' => $data['items_count'],
            'is_enabled' => $data['is_enabled'],
            'is_active' => $section->is_active,
        ]);

        // Verify the data was saved correctly
        $section->refresh();
        $savedData = $section->data ?? [];
        
        return redirect()->route('admin.homepage.news-ticker.index')
            ->with('success', 'News ticker settings updated successfully.')
            ->with('debug_info', [
                'saved_items_count' => $savedData['items_count'] ?? 'N/A',
                'saved_is_enabled' => $savedData['is_enabled'] ?? 'N/A',
                'saved_is_active' => $section->is_active,
            ]);
    }

    protected function clearCache(): void
    {
        // Clear the main homepage cache
        Cache::forget('homepage_v2_data');
        
        // Also clear any related caches that might be used
        // This ensures the homepage will fetch fresh data on next request
        try {
            // Clear tagged cache if supported (Redis)
            Cache::tags(['homepage', 'homepage_sections'])->flush();
        } catch (\Exception $e) {
            // Tags not supported by cache driver, that's okay
            // The main cache key is already cleared above
        }
        
        // Force clear any view cache that might be holding the homepage
        \Artisan::call('view:clear');
    }
}
