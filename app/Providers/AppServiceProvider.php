<?php

namespace App\Providers;

use App\Services\Contracts\IUserBankingService;
use App\Services\implementations\MelliBank;
use App\Services\implementations\UserBankingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IUserBankingService::class, UserBankingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
