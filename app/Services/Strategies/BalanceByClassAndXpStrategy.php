<?php

namespace App\Services\Strategies;

use App\Models\RpgSessionPlayer;
use Illuminate\Support\Collection;

class BalanceByClassAndXpStrategy implements BalanceStrategyInterface
{
    public function balance(Collection $players, int $playersPerGuild): array
    {
        $totalPlayers = $players->count();
        $onlyOneGuild = $totalPlayers < 2 * $playersPerGuild;

        $playersGroupedByClass = $this->organizePlayersByClassAndXp($players);

        if ($onlyOneGuild) {
            $requiredPlayers = $this->getMinimumComposition($playersGroupedByClass);

            $remainingPlayers = $players->diff($requiredPlayers)->shuffle();

            return [
                'guild1' => $requiredPlayers->merge($remainingPlayers->take($playersPerGuild - $requiredPlayers->count())),
                'guild2' => collect(),
            ];
        }

        $guild1 = collect();
        $guild2 = collect();

        $guild1XpTotal = 0;
        $guild2XpTotal = 0;

        $this->distributePlayersByXp($playersGroupedByClass, $guild1, $guild2, $guild1XpTotal, $guild2XpTotal);
        
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

    private function getMinimumComposition(Collection $playersGroupedByClass): Collection
    {
        $requiredPlayers = collect();

        $cleric = $playersGroupedByClass['cleric']->sortByDesc('xp')->first();
        if ($cleric) {
            $requiredPlayers->push($cleric);
        }

        $warrior = $playersGroupedByClass['warrior']->sortByDesc('xp')->first();
        if ($warrior) {
            $requiredPlayers->push($warrior);
        }

        $mageOrArcher = $playersGroupedByClass['mage']->sortByDesc('xp')->first();
        if (!$mageOrArcher) {
            $mageOrArcher = $playersGroupedByClass['archer']->sortByDesc('xp')->first();
        }
        if ($mageOrArcher) {
            $requiredPlayers->push($mageOrArcher);
        }

        return $requiredPlayers;
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

    private function distributePlayersByXp(Collection $playersGroupedByClass, Collection $guild1, Collection $guild2, int &$guild1XpTotal, int &$guild2XpTotal): void
    {
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
    }
}