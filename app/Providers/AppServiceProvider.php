<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\PlayerRepository;
use App\Repositories\RpgSessionPlayerRepository;
use App\Repositories\RpgSessionPlayerRepositoryInterface;
use App\Repositories\RpgSessionRepository;
use App\Repositories\RpgSessionRepositoryInterface;
use App\Services\Strategies\BalanceByClassStrategy;
use App\Services\Strategies\BalanceByXpStrategy;
use App\Services\Strategies\BalanceStrategyInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
        $this->app->bind(RpgSessionRepositoryInterface::class, RpgSessionRepository::class);
        $this->app->bind(RpgSessionPlayerRepositoryInterface::class, RpgSessionPlayerRepository::class);
        $this->app->bind(BalanceStrategyInterface::class, BalanceByXpStrategy::class);
        $this->app->bind(BalanceStrategyInterface::class, BalanceByClassStrategy::class);

    }

    public function boot(): void
    {
        //
    }
}
