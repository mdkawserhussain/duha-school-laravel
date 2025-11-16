<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\SetLocale::class);
        $middleware->web(append: [
            \App\Http\Middleware\CheckMaintenanceMode::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Log all exceptions with detailed context
        $exceptions->report(function (Throwable $e) {
            \Log::error('Exception occurred', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_url' => request()?->fullUrl(),
                'request_method' => request()?->method(),
            ]);
            
            // Special handling for JSON encoding errors
            if ($e instanceof \JsonException || str_contains($e->getMessage(), 'UTF-8') || str_contains($e->getMessage(), 'json')) {
                \Log::error('JSON/UTF-8 Encoding Error Detected', [
                    'exception_class' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'backtrace' => $e->getTrace(),
                    'request_data' => request()?->all(),
                ]);
            }
        });
        
        // Prevent announcement loading during exception rendering
        $exceptions->render(function (Throwable $e, $request) {
            // Mark that we're handling an exception
            if (app()->bound('exception') === false) {
                app()->instance('exception', $e);
            }
            
            // Sanitize exception message to prevent UTF-8 encoding errors
            try {
                $message = $e->getMessage();
                if ($message && !mb_check_encoding($message, 'UTF-8')) {
                    $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
                    if (!mb_check_encoding($message, 'UTF-8')) {
                        $message = 'An error occurred';
                    }
                }
            } catch (\Throwable $t) {
                // Ignore sanitization errors
            }
        });
    })->create();
