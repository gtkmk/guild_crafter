<?php

namespace App\Services\Strategies;

use App\Models\RpgSessionPlayer;
use Illuminate\Support\Collection;

class BalanceByClassAndXpStrategy implements BalanceStrategyInterface
{
    public function balance(Collection $players): array
    {
        $playersGroupedByClass = $this->organizePlayersByClassAndXp($players);

        $guild1 = collect();
        $guild2 = collect();

        $guild1XpTotal = 0;
        $guild2XpTotal = 0;

        foreach ($playersGroupedByClass as $class => $playersInClass) {
            foreach ($playersInClass as $player) {
                if ($guild1XpTotal <= $guild2XpTotal) {
                    $guild1->push($player);
                    $guild1XpTotal += $player['xp'];

                    $this->ensureClassBalance($guild1, $guild2, $player, $guild1XpTotal, $guild2XpTotal);
                } else {
                    $guild2->push($player);
                    $guild2XpTotal += $player['xp'];

                    $this->ensureClassBalance($guild2, $guild1, $player, $guild2XpTotal, $guild1XpTotal);
                }
            }
        }

        return [
            'guild1' => $guild1,
            'guild2' => $guild2,
        ];
    }

    private function organizePlayersByClassAndXp(Collection $players)
    {
        return $players->groupBy('class')->map(function ($playersInClass) {
            return $playersInClass->sortBy('xp');
        });
    }

    private function ensureClassBalance($sourceGuild, $targetGuild, $player, &$sourceGuildXpTotal, &$targetGuildXpTotal)
    {
        $sameClassPlayers = $sourceGuild->filter(function ($guildPlayer) use ($player) {
            return $guildPlayer['class'] === $player['class'];
        });

        if ($sameClassPlayers->count() > 1) {
            $lowestXpPlayer = $sameClassPlayers->sortBy('xp')->first();

            $sourceGuild->forget($sourceGuild->search($lowestXpPlayer));
            $targetGuild->push($lowestXpPlayer);

            $sourceGuildXpTotal -= $lowestXpPlayer['xp'];
            $targetGuildXpTotal += $lowestXpPlayer['xp'];
        }
    }
}
