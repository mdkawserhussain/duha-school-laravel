# Backend Implementation Guide - Zaitoon Academy

This guide outlines the Laravel backend implementation required to support the Zaitoon Academy frontend components.

---

## 1. Newsletter Subscription

### Model
```php
// app/Models/NewsletterSubscription.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsletterSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'status', // active, unsubscribed
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];
}
```

### Migration
```php
// database/migrations/xxxx_create_newsletter_subscriptions_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->enum('status', ['active', 'unsubscribed'])->default('active');
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
            
            $table->index('email');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
};
```

### Controller
```php
// app/Http/Controllers/NewsletterController.php
<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Rate limiting
        $key = 'newsletter:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json([
                'message' => 'Too many attempts. Please try again later.'
            ], 429);
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            $subscription = NewsletterSubscription::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'status' => 'active',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'subscribed_at' => now(),
                ]
            );

            if ($subscription->wasRecentlyCreated) {
                RateLimiter::hit($key, 300); // 5 minutes

                return response()->json([
                    'message' => 'Successfully subscribed to our newsletter!'
                ], 201);
            }

            return response()->json([
                'message' => 'You are already subscribed to our newsletter.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Newsletter subscription failed', [
                'email' => $validated['email'],
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'message' => 'An error occurred. Please try again later.'
            ], 500);
        }
    }
}
```

---

## 2. Contact Form

### Model
```php
// app/Models/ContactSubmission.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}
```

---

## 3. Routes

```php
// routes/web.php
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');

Route::post('/contact', [ContactController::class, 'submit'])
    ->name('contact.submit');
```

---

**Document Version**: 1.0  
**Last Updated**: 2025-11-22
