<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'link',
        'link_text',
        'is_active',
        'sort_order',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Override toArray to ensure all string fields are sanitized
     */
    public function toArray(): array
    {
        $array = parent::toArray();
        
        // Sanitize string fields before serialization
        if (isset($array['message'])) {
            $array['message'] = static::sanitizeUtf8($array['message']);
        }
        if (isset($array['link_text'])) {
            $array['link_text'] = static::sanitizeUtf8($array['link_text']);
        }
        
        return $array;
    }

    /**
     * Override jsonSerialize to ensure valid UTF-8
     */
    public function jsonSerialize(): array
    {
        $data = $this->toArray();
        
        // Final validation - ensure all string values can be JSON encoded
        foreach ($data as $key => $value) {
            if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                \Log::warning('Announcement::jsonSerialize invalid UTF-8 detected', [
                    'field' => $key,
                    'value_hex' => bin2hex(substr($value, 0, 100)),
                ]);
                $data[$key] = static::sanitizeUtf8($value);
            }
        }
        
        return $data;
    }

    /**
     * Accessor to sanitize message field for UTF-8
     */
    public function getMessageAttribute($value): ?string
    {
        try {
            \Log::debug('Announcement::getMessageAttribute', [
                'id' => $this->id ?? 'new',
                'value_type' => gettype($value),
                'value_length' => is_string($value) ? strlen($value) : null,
                'value_hex' => is_string($value) ? bin2hex(substr($value, 0, 50)) : null,
                'is_valid_utf8' => is_string($value) ? mb_check_encoding($value, 'UTF-8') : null,
                'backtrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3),
            ]);

            if (empty($value)) {
                return $value;
            }

            $sanitized = static::sanitizeUtf8($value);
            
            \Log::debug('Announcement::getMessageAttribute sanitized', [
                'id' => $this->id ?? 'new',
                'original_length' => strlen($value),
                'sanitized_length' => strlen($sanitized ?? ''),
                'changed' => $value !== $sanitized,
            ]);

            return $sanitized;
        } catch (\Throwable $e) {
            \Log::error('Announcement::getMessageAttribute ERROR', [
                'id' => $this->id ?? 'new',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Accessor to sanitize link_text field for UTF-8
     */
    public function getLinkTextAttribute($value): ?string
    {
        try {
            \Log::debug('Announcement::getLinkTextAttribute', [
                'id' => $this->id ?? 'new',
                'value_type' => gettype($value),
                'value_length' => is_string($value) ? strlen($value) : null,
                'is_valid_utf8' => is_string($value) ? mb_check_encoding($value, 'UTF-8') : null,
            ]);

            if (empty($value)) {
                return $value;
            }

            $sanitized = static::sanitizeUtf8($value);
            
            \Log::debug('Announcement::getLinkTextAttribute sanitized', [
                'id' => $this->id ?? 'new',
                'changed' => $value !== $sanitized,
            ]);

            return $sanitized;
        } catch (\Throwable $e) {
            \Log::error('Announcement::getLinkTextAttribute ERROR', [
                'id' => $this->id ?? 'new',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Mutator to sanitize message field before saving
     */
    public function setMessageAttribute($value): void
    {
        if ($value === null || $value === '') {
            $this->attributes['message'] = null;
            return;
        }
        
        // Sanitize the value
        $sanitized = static::sanitizeUtf8((string) $value);
        
        // Only save if sanitization didn't completely remove the content
        // If sanitization returns null, it means the content was invalid
        // In that case, preserve the original value to prevent data loss
        if ($sanitized === null && !empty($value)) {
            \Log::warning('Announcement::setMessageAttribute sanitization returned null for non-empty value', [
                'original_length' => strlen((string) $value),
                'original_hex' => bin2hex(substr((string) $value, 0, 50)),
            ]);
            // Try to preserve the original value but still clean it minimally
            $this->attributes['message'] = trim((string) $value);
        } else {
            $this->attributes['message'] = $sanitized;
        }
    }

    /**
     * Mutator to sanitize link_text field before saving
     */
    public function setLinkTextAttribute($value): void
    {
        if ($value === null || $value === '') {
            $this->attributes['link_text'] = null;
            return;
        }
        
        // Sanitize the value
        $sanitized = static::sanitizeUtf8((string) $value);
        
        // Only save if sanitization didn't completely remove the content
        if ($sanitized === null && !empty($value)) {
            $this->attributes['link_text'] = trim((string) $value);
        } else {
            $this->attributes['link_text'] = $sanitized;
        }
    }

    /**
     * Scope to get only active announcements that are currently valid
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', $now);
            });
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Get all active announcements for display
     * Completely fail-safe to prevent breaking error pages
     */
    public static function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        // Early return for error contexts - don't even try to query
        if (app()->runningInConsole() || 
            app()->runningUnitTests() || 
            (function_exists('app') && app()->bound('exception')) ||
            (function_exists('request') && (
                request()->is('_dusk/*') ||
                request()->is('telescope/*') ||
                request()->is('errors/*')
            ))) {
            return (new static)->newCollection();
        }

        try {
            $announcements = static::active()->ordered()->get();
            
            if ($announcements->isEmpty()) {
                return (new static)->newCollection();
            }
            
            // Accessors already sanitize the data when accessed
            // Just ensure each announcement has a valid message
            $validAnnouncements = (new static)->newCollection();
            foreach ($announcements as $announcement) {
                try {
                    // Access the message through the accessor (which sanitizes)
                    $message = $announcement->message;
                    
                    // Only skip if message is truly empty/null after sanitization
                    // This should rarely happen since mutator sanitizes on save
                    if (empty($message)) {
                        \Log::warning('Announcement skipped due to empty message after sanitization', [
                            'id' => $announcement->id,
                            'raw_message' => $announcement->getRawOriginal('message'),
                        ]);
                        continue;
                    }
                    
                    // Final validation - ensure it can be JSON encoded
                    $test = json_encode($message, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                    if ($test === false) {
                        \Log::warning('Announcement skipped due to JSON encoding failure', [
                            'id' => $announcement->id,
                        ]);
                        continue;
                    }
                    
                    $validAnnouncements->push($announcement);
                } catch (\Throwable $e) {
                    // Skip this announcement if anything fails
                    \Log::warning('Announcement skipped due to exception', [
                        'id' => $announcement->id ?? 'unknown',
                        'error' => $e->getMessage(),
                    ]);
                    continue;
                }
            }
            
            return $validAnnouncements;
        } catch (\Throwable $e) {
            // Completely fail-safe - return empty Eloquent collection
            \Log::error('Announcement::getActive() exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return (new static)->newCollection();
        }
    }

    /**
     * Sanitize string to ensure valid UTF-8 encoding
     */
    protected static function sanitizeUtf8(?string $string): ?string
    {
        if (empty($string)) {
            return $string;
        }

        try {
            \Log::debug('Announcement::sanitizeUtf8 START', [
                'input_type' => gettype($string),
                'input_length' => strlen($string),
                'input_hex' => bin2hex(substr($string, 0, 100)),
                'is_valid_utf8_before' => mb_check_encoding($string, 'UTF-8'),
            ]);

            // First, ensure it's a valid string
            if (!is_string($string)) {
                $string = (string) $string;
                \Log::debug('Announcement::sanitizeUtf8 converted to string');
            }

            // Remove null bytes and other control characters
            $string = str_replace(["\x00", "\r"], '', $string);
            \Log::debug('Announcement::sanitizeUtf8 after null removal', [
                'length' => strlen($string),
            ]);
            
            // Convert to UTF-8, removing invalid sequences
            if (function_exists('mb_convert_encoding')) {
                $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
                \Log::debug('Announcement::sanitizeUtf8 after mb_convert_encoding', [
                    'length' => strlen($string),
                    'is_valid_utf8' => mb_check_encoding($string, 'UTF-8'),
                ]);
            }
            
            // Remove control characters except newlines and tabs
            $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $string) ?? '';
            \Log::debug('Announcement::sanitizeUtf8 after control char removal', [
                'length' => strlen($string),
            ]);
            
            // Validate and fix encoding
            if (function_exists('mb_check_encoding')) {
                if (!mb_check_encoding($string, 'UTF-8')) {
                    \Log::warning('Announcement::sanitizeUtf8 invalid UTF-8 detected, attempting fix');
                    if (function_exists('iconv')) {
                        $string = @iconv('UTF-8', 'UTF-8//IGNORE', $string);
                        if ($string === false) {
                            $string = '';
                            \Log::warning('Announcement::sanitizeUtf8 iconv returned false');
                        } else {
                            \Log::debug('Announcement::sanitizeUtf8 after iconv', [
                                'length' => strlen($string),
                                'is_valid_utf8' => mb_check_encoding($string, 'UTF-8'),
                            ]);
                        }
                    } else {
                        // Remove invalid UTF-8 bytes using regex
                        $string = preg_replace('/[\x80-\xFF](?![\x80-\xBF]{0,2})/u', '', $string) ?? '';
                        \Log::debug('Announcement::sanitizeUtf8 after regex cleanup', [
                            'length' => strlen($string),
                        ]);
                    }
                }
            }
            
            // Final check - ensure it can be JSON encoded
            if (!empty($string)) {
                \Log::debug('Announcement::sanitizeUtf8 testing JSON encode', [
                    'string_length' => strlen($string),
                    'is_valid_utf8' => mb_check_encoding($string, 'UTF-8'),
                ]);
                
                $test = json_encode($string, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                $jsonError = json_last_error();
                
                if ($test === false || $jsonError !== JSON_ERROR_NONE) {
                    \Log::error('Announcement::sanitizeUtf8 JSON encode FAILED', [
                        'json_error' => $jsonError,
                        'json_error_msg' => json_last_error_msg(),
                        'string_hex' => bin2hex(substr($string, 0, 100)),
                    ]);
                    
                    // If JSON encoding fails, use iconv to clean it
                    if (function_exists('iconv')) {
                        $string = @iconv('UTF-8', 'UTF-8//IGNORE', $string);
                        if ($string === false) {
                            $string = '';
                            \Log::error('Announcement::sanitizeUtf8 iconv failed on retry');
                        } else {
                            \Log::debug('Announcement::sanitizeUtf8 retry after iconv', [
                                'length' => strlen($string),
                            ]);
                        }
                    } else {
                        $string = '';
                        \Log::error('Announcement::sanitizeUtf8 no iconv available, returning empty');
                    }
                } else {
                    \Log::debug('Announcement::sanitizeUtf8 JSON encode SUCCESS');
                }
            }
            
            $result = $string ?: null;
            \Log::debug('Announcement::sanitizeUtf8 COMPLETE', [
                'result_length' => $result ? strlen($result) : 0,
                'result_is_valid_utf8' => $result ? mb_check_encoding($result, 'UTF-8') : true,
            ]);
            
            return $result;
        } catch (\Throwable $e) {
            \Log::error('Announcement::sanitizeUtf8 EXCEPTION', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    /**
     * Check if announcement is currently valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }
}

