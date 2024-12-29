<?php

namespace App\Services\Strategies;

use Illuminate\Support\Collection;

interface BalanceStrategyInterface
{
    public function balance(Collection $players, int $playersPerGuild): array;
}
