<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

// Konfigurasi route bawaan
// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         commands: __DIR__.'/../routes/console.php',
//         health: '/up',
//         then: function() {
//             Route::middleware('api')
//                 ->prefix('webhooks')
//                 ->name('webhooks')
//                 ->group(base_path('routes/webhooks.php'));
//         }
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         //
//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     })->create();

// Konfigurasi route ketika ingin membuat file route sendiri
return Application::configure(basePath:dirname(__DIR__))
        ->withRouting(
            web: __DIR__ . '/../routes/web.php',
            commands: __DIR__ . '/../routes/console.php',
            health: '/status',
            then: function() {
                Route::middleware('web')
                    ->name('webhooks')
                    ->prefix('webhooks')
                    ->group(base_path('routes/webhooks.php'));
            }
        )
        ->withMiddleware(function(Middleware $middleware) {
            // code disini
        })
        ->withExceptions(function(Exceptions $exceptions){
            // code disini
        })->create();

// Konfigurasi route ketika ingin kontrol penuh
// return Application::configure(basePath:dirname(__DIR__))
//             ->withRouting(
//     commands: __DIR__.'/../routes/console.php',
//     using: function () {
//         Route::middleware('api')
//             ->prefix('api')
//             ->group(base_path('routes/api.php'));

//         Route::middleware('web')
//             ->group(base_path('routes/web.php'));
//     },
// )
//             ->create();
