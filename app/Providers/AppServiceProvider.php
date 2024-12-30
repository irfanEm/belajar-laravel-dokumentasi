<?php

namespace App\Providers;

use App\Contracts\Mailer;
use App\Models\User;
use App\Services\SmtpMailer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Mailer::class, SmtpMailer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::pattern('gb_id', '[0-9a-z]+');
        URL::defaults(['default' => 'bismillah']);

        // Explicit binding model
        Route::model('user', User::class);

    }
}
