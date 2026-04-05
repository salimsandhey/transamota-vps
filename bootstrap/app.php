<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        channels: __DIR__.'/../routes/channels.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'seller' => \App\Http\Middleware\EnsureSeller::class,
            'buyer' => \App\Http\Middleware\EnsureBuyer::class,
            'auth' => \App\Http\Middleware\EnsureAuthenticated::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'verified' => \App\Http\Middleware\EnsureEmailVerified::class,
            'seller.verified' => \App\Http\Middleware\EnsureSellerVerified::class,
            'buyer.approved' => \App\Http\Middleware\EnsureBuyerApproved::class,
        ]);
        
        $middleware->web(\App\Http\Middleware\VerifyCsrfToken::class);
        $middleware->web(\App\Http\Middleware\UpdateUserTimezone::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();