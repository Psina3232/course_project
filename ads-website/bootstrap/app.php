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
        $middleware->validateCsrfTokens(except: [
            'http://127.0.0.1:8000/register',
            'http://127.0.0.1:8000/login',
            'http://127.0.0.1:8000/logout',
            'http://127.0.0.1:8000/home'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
