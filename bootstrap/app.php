<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
        |--------------------------------------------------------------------------
        | Global Middleware or Groups
        |--------------------------------------------------------------------------
        */

        // If you want to add global middleware, you can use:
        // $middleware->append(\App\Http\Middleware\YourGlobalMiddleware::class);

        /*
        |--------------------------------------------------------------------------
        | Route Middleware (aliases)
        |--------------------------------------------------------------------------
        |
        | Here we manually register middleware aliases like 'guest', 'auth', etc.
        | So we can use them in routes or controllers.
        |
        */

        $middleware->alias([
            'auth'  => \App\Http\Middleware\Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
