<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PartnersController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where(function($query) {
            $query->where('section_key', 'partners')
                  ->orWhere('section_key', 'our_partners');
        })
        ->where('section_type', 'partners')
        ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'partners',
                'section_type' => 'partners',
                'title' => 'Our Partners',
                'description' => 'We are proud to be associated with leading organizations worldwide.',
                'data' => [
                    'partners' => [],
                ],
                'sort_order' => 21,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $partners = data_get($data, 'partners', []);

        return view('admin.homepage.partners.index', [
            'section' => $section,
            'partners' => $partners,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable'],
            'partners' => ['required', 'array', 'min:1'],
            'partners.*.name' => ['required', 'string', 'max:255'],
            'partners.*.link' => ['required', 'string', 'max:255'],
            'partners.*.website' => ['nullable', 'url', 'max:255'],
            'partners.*.logo' => ['nullable', 'image', 'max:5120'],
        ]);

        $section = HomePageSection::where(function($query) {
            $query->where('section_key', 'partners')
                  ->orWhere('section_key', 'our_partners');
        })
        ->where('section_type', 'partners')
        ->firstOrFail();

        // Properly cast checkbox value to boolean
        $section->title = $validated['title'] ?? null;
        $section->description = $validated['description'] ?? null;
        $section->is_active = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);

        $data = $section->data ?? [];
        $data['partners'] = $validated['partners'];
        $section->data = $data;
        $section->save();

        // Handle logo uploads
        if ($request->hasFile('partners')) {
            foreach ($request->file('partners') as $index => $logo) {
                if ($logo && isset($validated['partners'][$index])) {
                    $media = $section->getMedia('partner_logos')->get($index);
                    if ($media) {
                        $media->delete();
                    }
                    $section->addMedia($logo)
                        ->usingName("Partner Logo {$index}")
                        ->toMediaCollection('partner_logos');
                    $data['partners'][$index]['logo'] = $section->getMedia('partner_logos')->get($index)?->getUrl();
                }
            }
            $section->data = $data;
            $section->save();
        }
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        return redirect()->route('admin.homepage.partners.index')
            ->with('success', 'Partners section updated successfully.');
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
