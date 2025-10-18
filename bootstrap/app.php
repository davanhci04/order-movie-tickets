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
            'force.https' => \App\Http\Middleware\ForceHttps::class,
        ]);
        
        // Apply HTTPS middleware globally for production
        if (config('app.env') === 'production') {
            $middleware->prepend(\App\Http\Middleware\ForceHttps::class);
        }
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
