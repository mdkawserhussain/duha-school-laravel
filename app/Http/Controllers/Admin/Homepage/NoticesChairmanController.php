<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NoticesChairmanController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where('section_key', 'notices_chairman')
            ->where('section_type', 'notices_chairman')
            ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'notices_chairman',
                'section_type' => 'notices_chairman',
                'title' => 'Notices & Chairman',
                'description' => 'Control notices and chairman message display settings',
                'data' => [
                    'show_notices' => true,
                    'notices_count' => 5,
                    'show_chairman' => true,
                    'chairman_excerpt_limit' => 150,
                ],
                'sort_order' => 11,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $settings = [
            'show_notices' => data_get($data, 'show_notices', true),
            'notices_count' => data_get($data, 'notices_count', 5),
            'show_chairman' => data_get($data, 'show_chairman', true),
            'chairman_excerpt_limit' => data_get($data, 'chairman_excerpt_limit', 150),
        ];

        return view('admin.homepage.notices-chairman.index', [
            'section' => $section,
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'show_notices' => ['nullable'],
            'notices_count' => ['required', 'integer', 'min:1', 'max:20'],
            'show_chairman' => ['nullable'],
            'chairman_excerpt_limit' => ['required', 'integer', 'min:50', 'max:500'],
        ]);

        $section = HomePageSection::where('section_key', 'notices_chairman')
            ->where('section_type', 'notices_chairman')
            ->firstOrFail();

        // Properly cast checkbox values to boolean
        $data = $section->data ?? [];
        $data['show_notices'] = filter_var($request->input('show_notices'), FILTER_VALIDATE_BOOLEAN);
        $data['notices_count'] = (int) $validated['notices_count'];
        $data['show_chairman'] = filter_var($request->input('show_chairman'), FILTER_VALIDATE_BOOLEAN);
        $data['chairman_excerpt_limit'] = (int) $validated['chairman_excerpt_limit'];
        
        $section->data = $data;
        $section->save();
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        Log::info('Notices & Chairman settings updated', [
            'show_notices' => $data['show_notices'],
            'notices_count' => $data['notices_count'],
            'show_chairman' => $data['show_chairman'],
            'chairman_excerpt_limit' => $data['chairman_excerpt_limit'],
        ]);

        return redirect()->route('admin.homepage.notices-chairman.index')
            ->with('success', 'Notices & Chairman settings updated successfully.');
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
