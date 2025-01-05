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

    //check role admin if role == 1;
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleAuth::class,
        ]);

    })

    //status check addmin;
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'status' => \App\Http\Middleware\StatusAuth::class,
        ]);
    })

    //check role user if role == 0 ;
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'userRole' => \App\Http\Middleware\UserRoleAuth::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'adminArea' => \App\Http\Middleware\AdminArea::class,
        ]);
    })

    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'check' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    
