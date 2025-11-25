<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Passport::hashClientSecrets();

       Passport::tokensExpireIn(Carbon::now()->addHour(1));
       Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(30));
       Passport::personalAccessTokensExpireIn(Carbon::now()->addHour(1));


    }
}
