<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Admin\BaseController;
use App\Models\HomePageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestimonialsController extends BaseController
{
    public function index()
    {
        $section = HomePageSection::where(function($query) {
            $query->where('section_key', 'testimonials')
                  ->orWhere('section_key', 'parent_testimonials');
        })
        ->where('section_type', 'testimonials')
        ->first();

        // Create default section if it doesn't exist
        if (!$section) {
            $section = HomePageSection::create([
                'section_key' => 'testimonials',
                'section_type' => 'testimonials',
                'title' => 'What Parents Say About Duha International School',
                'description' => 'Hear from parents about their experience with Duha International School',
                'data' => [
                    'testimonials' => [],
                ],
                'sort_order' => 20,
                'is_active' => true,
            ]);
        }

        $data = $section->data ?? [];
        $testimonials = data_get($data, 'testimonials', []);

        return view('admin.homepage.testimonials.index', [
            'section' => $section,
            'testimonials' => $testimonials,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable'],
            'testimonials' => ['required', 'array', 'min:1'],
            'testimonials.*.quote' => ['required', 'string', 'max:1000'],
            'testimonials.*.author' => ['required', 'string', 'max:255'],
            'testimonials.*.role' => ['nullable', 'string', 'max:255'],
            'testimonials.*.student' => ['nullable', 'string', 'max:255'],
            'testimonials.*.avatar' => ['nullable', 'image', 'max:5120'],
        ]);

        $section = HomePageSection::where(function($query) {
            $query->where('section_key', 'testimonials')
                  ->orWhere('section_key', 'parent_testimonials');
        })
        ->where('section_type', 'testimonials')
        ->firstOrFail();

        // Properly cast checkbox value to boolean
        $section->title = $validated['title'] ?? null;
        $section->description = $validated['description'] ?? null;
        $section->is_active = filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN);

        $data = $section->data ?? [];
        $data['testimonials'] = $validated['testimonials'];
        $section->data = $data;
        $section->save();

        // Handle avatar uploads
        if ($request->hasFile('testimonials')) {
            foreach ($request->file('testimonials') as $index => $avatar) {
                if ($avatar && isset($validated['testimonials'][$index])) {
                    $media = $section->getMedia('testimonial_avatars')->get($index);
                    if ($media) {
                        $media->delete();
                    }
                    $section->addMedia($avatar)
                        ->usingName("Testimonial Avatar {$index}")
                        ->toMediaCollection('testimonial_avatars');
                    $data['testimonials'][$index]['avatar'] = $section->getMedia('testimonial_avatars')->get($index)?->getUrl();
                }
            }
            $section->data = $data;
            $section->save();
        }
        
        // Refresh the model to ensure data is up to date
        $section->refresh();

        $this->clearCache();

        return redirect()->route('admin.homepage.testimonials.index')
            ->with('success', 'Testimonials section updated successfully.');
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
