<?php

namespace App\Providers;

use App\Contracts\Mailer;
use App\Models\Item;
use App\Models\User;
use App\Services\SmtpMailer;
use App\View\Composers\TestComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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

        // Customizing resolution logic
        //Route::bind('item', function(string $value) {
            // cari item berdasarkan nama
            //return Item::where('name', $value)->firstOrFail();
        //});

        // Route limiter
        RateLimiter::for('upload', function(Request $request){
            return Limit::perMinute(5)->by($request->user()?->id ? : $request->ip());
        });

        view()->share('appName', 'Lara App by Im.');

        view()->composer('stream-download', TestComposer::class);
    }
}
