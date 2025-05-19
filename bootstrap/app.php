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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'register',
            'login',
            'register/Driver',
            'registerDriver.submit',
            '/verify-otp',
           'client/*/upload-profile-image',
           '/Social/verify-otp',
           '/set-password',
           '/logout'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
