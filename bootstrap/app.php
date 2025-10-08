<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


        /* use Illuminate\Foundation\Application;
        use Illuminate\Foundation\Configuration\Exceptions;
        use Illuminate\Foundation\Configuration\Middleware; */

        $app = Application::configure(basePath: dirname(__DIR__))
                            ->withRouting(
                                web: __DIR__.'/../routes/web.php',
                                commands: __DIR__.'/../routes/console.php',
                                health: '/up',
                            )
                            ->withMiddleware(function (Middleware $middleware) {
                                $middleware->alias([
                                    'role'          => \App\Http\Middleware\RoleAuth::class,
                                    'maintenance'   => \App\Http\Middleware\MaintenanceStatus::class,
                                    'status'        => \App\Http\Middleware\StatusAuth::class,
                                    'rights_area'   => \App\Http\Middleware\RightsArea::class,
                                    'userRole'      => \App\Http\Middleware\UserRoleAuth::class,
                                    'adminArea'     => \App\Http\Middleware\AdminArea::class,
                                    'check'         => \App\Http\Middleware\EnsureUserHasRole::class,
                                    'adminRole'     => \App\Http\Middleware\AdminRoleAuth::class,
                                    'statusOnline'  => \App\Http\Middleware\StatusOnline::class,
                                    'purReport'     => \App\Http\Middleware\PurchaseReport::class,
                                    'CheckPurReport'=> \App\Http\Middleware\CheckPurchaseReport::class,
                                    'CustomerDetailCheck'=> \App\Http\Middleware\CustomerDetailCheck::class,
                                    'confirmType'=> \App\Http\Middleware\CheckTypeStore::class,
                                    'allowedType'=> \App\Http\Middleware\CheckTypeUser::class,
                                    'checkMenu'=> \App\Http\Middleware\CheckMenuAdmin::class,
                                ]);
                            })
                            ->withExceptions(function (Exceptions $exceptions) {
                                //
                            })->create();

        // ทำให้ artisan และ schedule ทำงานได้
        $app->singleton(
            Illuminate\Contracts\Console\Kernel::class,
            App\Console\Kernel::class
        );

        return $app;


    //แบบเดิม;
  /* return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    ) */

        /* $app = Application::configure(basePath: dirname(__DIR__))
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

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'maintenance' => \App\Http\Middleware\MaintenanceStatus::class,
            ]);
        })

        //status check addmin;
        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'status' => \App\Http\Middleware\StatusAuth::class,
            ]);
        })

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'rights_area' => \App\Http\Middleware\RightsArea::class,
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

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'adminRole' => \App\Http\Middleware\AdminRoleAuth::class,
            ]);
        })

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'statusOnline' => \App\Http\Middleware\StatusOnline::class,
            ]);
        })

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'purReport' => \App\Http\Middleware\PurchaseReport::class,
            ]);
        })

        ->withMiddleware(function (Middleware $middleware) {

            $middleware->alias([
                'CheckPurReport' => \App\Http\Middleware\CheckPurchaseReport::class,
            ]);
        })

        ->withExceptions(function (Exceptions $exceptions) {
            //
        })->create();

        // ✅ เพิ่มการ bind Console Kernel แบบ Laravel 10
        $app->singleton(
            Illuminate\Contracts\Console\Kernel::class,
            App\Console\Kernel::class
        );

        return $app; */
    
