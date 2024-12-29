<?php

namespace App\Providers;

use App\Services\Strategies\BalanceByClassAndXpWithGreedyStrategy ;
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
use App\Services\Validation\GuildValidator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
        $this->app->bind(RpgSessionRepositoryInterface::class, RpgSessionRepository::class);
        $this->app->bind(RpgSessionPlayerRepositoryInterface::class, RpgSessionPlayerRepository::class);
        $this->app->bind(BalanceStrategyInterface::class, BalanceByClassAndXpWithGreedyStrategy ::class);
        $this->app->bind(GuildValidator::class, function ($app) {
            return new GuildValidator();
        });

    }

    public function boot(): void
    {
        //
    }
}
