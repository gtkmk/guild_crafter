<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\PlayerRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
