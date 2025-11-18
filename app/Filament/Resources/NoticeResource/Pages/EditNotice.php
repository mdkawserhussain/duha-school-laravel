<?php

namespace App\Filament\Resources\NoticeResource\Pages;

use App\Filament\Resources\NoticeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class EditNotice extends EditRecord
{
    protected static string $resource = NoticeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->url(fn () => route('notices.show', $this->record))
                ->openUrlInNewTab()
                ->visible(fn () => $this->record->is_published ?? false),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->after(function () {
                    // Clear caches after delete
                    Cache::forget('homepage_v2_data');
                    $this->clearNoticeCaches();
                }),
        ];
    }

    /**
     * Mutate form data before filling the form (when loading existing notice).
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ensure is_published and is_important are boolean values
        if (isset($data['is_published'])) {
            $data['is_published'] = (bool) $data['is_published'];
        }
        if (isset($data['is_important'])) {
            $data['is_important'] = (bool) $data['is_important'];
        }

        return $data;
    }

    /**
     * Mutate form data before saving.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure is_published is set and boolean
        $data['is_published'] = isset($data['is_published']) ? (bool) $data['is_published'] : false;
        
        // Ensure is_important is set and boolean
        $data['is_important'] = isset($data['is_important']) ? (bool) $data['is_important'] : false;

        // Ensure excerpt is set (required field in database)
        // If not provided, generate from content
        if (empty($data['excerpt']) || trim($data['excerpt']) === '') {
            $content = strip_tags($data['content'] ?? $this->record->content ?? '');
            $data['excerpt'] = \Illuminate\Support\Str::limit($content, 200);
        }

        // Remove any non-existent fields (status, is_featured if they somehow got in)
        unset($data['status'], $data['is_featured']);

        // Remove file upload fields from data as we'll handle them manually
        unset($data['featured_image']);

        return $data;
    }

    /**
     * Handle successful save.
     */
    protected function afterSave(): void
    {
        $notice = $this->record;
        $formState = $this->form->getRawState();

        // Handle featured_image upload
        if (isset($formState['featured_image']) && !empty($formState['featured_image'])) {
            $this->handleMediaUpload($notice, $formState['featured_image'], 'featured_image');
        }

        // Clear notice-related caches when notice is saved
        Cache::forget('homepage_v2_data');
        $this->clearNoticeCaches();

        Notification::make()
            ->title('Notice updated successfully')
            ->success()
            ->send();
    }

    /**
     * Handle media upload from Filament FileUpload to Spatie Media Library.
     */
    protected function handleMediaUpload($notice, $filePath, string $collection): void
    {
        if (!$filePath) {
            return;
        }

        // Handle array of file paths (Filament uses associative arrays with UUID keys)
        if (is_array($filePath)) {
            if (empty($filePath)) {
                return;
            }
            // Get the first value from the array
            if (!empty($filePath[0])) {
                $filePath = $filePath[0];
            } else {
                $filePath = reset($filePath); // Get first value from associative array
            }
        }

        if (!$filePath || !is_string($filePath)) {
            return;
        }

        // Skip if it's a URL (already uploaded and in media collection)
        if (filter_var($filePath, FILTER_VALIDATE_URL)) {
            return;
        }

        // Clear existing media in collection (for single file collections)
        $notice->clearMediaCollection($collection);

        // Handle Livewire temporary files
        if (str_starts_with($filePath, 'livewire-tmp/')) {
            $fullPath = storage_path('app/public/' . $filePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                $notice->addMedia($fullPath)->toMediaCollection($collection);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
                $notice->addMediaFromDisk($filePath, 'public')->toMediaCollection($collection);
            }
        } else {
            // Handle files in notices directory
            $possiblePaths = [
                'notices/' . basename($filePath),
                $filePath,
            ];

            foreach ($possiblePaths as $testPath) {
                $fullPath = storage_path('app/public/' . $testPath);
                if (file_exists($fullPath) && is_file($fullPath)) {
                    $notice->addMedia($fullPath)->toMediaCollection($collection);
                    break;
                } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($testPath)) {
                    $notice->addMediaFromDisk($testPath, 'public')->toMediaCollection($collection);
                    break;
                }
            }
        }
    }

    /**
     * Clear notice-related caches.
     */
    protected function clearNoticeCaches(): void
    {
        try {
            // Clear specific notice cache keys (commonly used)
            $noticeCacheKeys = [
                'notices_recent_5',
                'notices_important_5',
            ];

            foreach ($noticeCacheKeys as $key) {
                Cache::forget($key);
            }

            // Clear notice-specific caches (pattern-based clearing for Redis)
            if (config('cache.default') === 'redis') {
                try {
                    $redis = Cache::getRedis();
                    $patterns = [
                        'notices_published_*',
                        'notices_important_*',
                        'notices_category_*',
                        'notices_recent_*',
                    ];

                    foreach ($patterns as $pattern) {
                        $keys = $redis->keys($pattern);
                        if (!empty($keys)) {
                            $redis->del($keys);
                        }
                    }
                } catch (\Exception $e) {
                    // If pattern clearing fails, log and continue
                    \Illuminate\Support\Facades\Log::warning('Failed to clear notice caches by pattern', [
                        'error' => $e->getMessage(),
                    ]);
                }
            } else {
                // For non-Redis cache drivers (database, file), clear common pagination keys
                // This is a best-effort approach since we can't pattern match with these drivers
                for ($page = 1; $page <= 10; $page++) {
                    for ($perPage = 12; $perPage <= 24; $perPage += 12) {
                        $cacheKey = 'notices_published_' . md5(serialize([$perPage, $page]));
                        Cache::forget($cacheKey);
                    }
                }
                
                // Clear category-based caches
                $categories = ['Academic', 'Administrative', 'Events', 'General'];
                foreach ($categories as $category) {
                    for ($page = 1; $page <= 10; $page++) {
                        for ($perPage = 12; $perPage <= 24; $perPage += 12) {
                            $cacheKey = 'notices_category_' . md5(serialize([$category, $perPage, $page]));
                            Cache::forget($cacheKey);
                        }
                    }
                }
            }

            \Illuminate\Support\Facades\Log::info('Notice caches cleared', [
                'cache_driver' => config('cache.default'),
                'homepage_cache_cleared' => true,
                'notice_caches_cleared' => true,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error clearing notice caches', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}