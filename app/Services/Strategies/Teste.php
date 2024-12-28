<?php

namespace App\Services\Strategies;

use App\Models\RpgSessionPlayer;
use Illuminate\Support\Collection;

class Teste implements BalanceStrategyInterface
{
    public function balance(Collection $players, int $playersPerGuild): array
    {
        $totalPlayers = $players->count();

        // Regra 1: Apenas uma guilda se o total de jogadores for menor que 2x playersPerGuild
        if ($totalPlayers < 2 * $playersPerGuild) {
            return [
                'guild1' => $this->createSingleGuild($players, $playersPerGuild),
                'guild2' => collect(),
            ];
        }

        // Regra 2: Duas guildas com balanceamento por XP
        return $this->balanceTwoGuilds($players, $playersPerGuild);
    }

    private function createSingleGuild(Collection $players, int $playersPerGuild): Collection
    {
        $requiredPlayers = $this->getMinimumComposition($players);

        // Preencher o restante da guilda com base no maior XP
        $remainingPlayers = $players->diff($requiredPlayers)
                                    ->sortByDesc('xp')
                                    ->take($playersPerGuild - $requiredPlayers->count());

        return $requiredPlayers->merge($remainingPlayers);
    }

    private function balanceTwoGuilds(Collection $players, int $playersPerGuild): array
    {
        $playersGroupedByClass = $this->organizePlayersByClassAndXp($players);

        $guild1 = collect();
        $guild2 = collect();

        $guild1XpTotal = 0;
        $guild2XpTotal = 0;

        foreach ($playersGroupedByClass as $class => $playersInClass) {
            foreach ($playersInClass as $player) {
                if ($guild1->count() < $playersPerGuild && $guild1XpTotal <= $guild2XpTotal) {
                    $guild1->push($player);
                    $guild1XpTotal += $player['xp'];

                    $this->ensureClassBalance($guild1, $guild2, $player, $guild1XpTotal, $guild2XpTotal);
                } elseif ($guild2->count() < $playersPerGuild) {
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

    private function getMinimumComposition(Collection $players): Collection
    {
        $classes = ['Warrior', 'Cleric', 'Archer', 'Mage'];
        $minimumComposition = collect();

        foreach ($classes as $class) {
            $player = $players->firstWhere('class', $class);
            if ($player) {
                $minimumComposition->push($player);
                $players = $players->reject(fn($p) => $p['id'] === $player['id']);
            }
        }

        if (!$minimumComposition->firstWhere('class', 'Warrior') || !$minimumComposition->firstWhere('class', 'Cleric')) {
            throw new \Exception('Not enough players to satisfy the minimum class composition.');
        }

        return $minimumComposition;
    }

    private function organizePlayersByClassAndXp(Collection $players): Collection
    {
        return $players->groupBy('class')->map(function ($playersInClass) {
            return $playersInClass->sortByDesc('xp');
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