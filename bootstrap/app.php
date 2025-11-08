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
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 500 errors gracefully
        $exceptions->render(function (Throwable $e, $request) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $statusCode = $e->getStatusCode();
                
                // If in production and not debug mode, show custom error pages
                if (app()->environment('production') && !config('app.debug')) {
                    if (view()->exists("errors.{$statusCode}")) {
                        return response()->view("errors.{$statusCode}", [], $statusCode);
                    }
                }
            }
            
            // For other exceptions in production, show generic 500 page
            if (app()->environment('production') && !config('app.debug')) {
                if (view()->exists('errors.500')) {
                    return response()->view('errors.500', [], 500);
                }
            }
        });
    })->create();
