<?php

namespace App\Services\Strategies;

use App\Models\Player;
use Illuminate\Support\Collection;

class BalanceByClassAndXpWithGreedyStrategy implements BalanceStrategyInterface
{
    public function balance(Collection $players, int $playersPerGuild): array
    {
        $totalPlayers = $players->count();
        $onlyOneGuild = $totalPlayers < 2 * $playersPerGuild;

        $playersGroupedByClass = $players->groupBy('class')->map(fn($group) => $group->sortByDesc('xp'));

        if ($onlyOneGuild) {
            return $this->balanceForSingleGuild($players, $playersPerGuild, $playersGroupedByClass);
        }

        return $this->balanceForMultipleGuilds($playersGroupedByClass, $playersPerGuild);
    }

    private function balanceForSingleGuild(Collection $players, int $playersPerGuild, Collection $playersGroupedByClass): array
    {
        $requiredPlayers = $this->getMinimumComposition($playersGroupedByClass);
        $remainingPlayers = $players->diff($requiredPlayers)->sortByDesc('xp');

        return [
            'guild1' => $requiredPlayers->merge($remainingPlayers->take($playersPerGuild - $requiredPlayers->count())),
            'guild2' => collect(),
        ];
    }

    private function balanceForMultipleGuilds(Collection $playersGroupedByClass, int $playersPerGuild): array
    {
        $guild1 = collect();
        $guild2 = collect();

        $this->fillMinimumComposition($playersGroupedByClass, $guild1, $guild2);

        $remainingPlayers = $this->getRemainingPlayers($playersGroupedByClass, $guild1, $guild2);
        $this->balanceRemainingPlayers($remainingPlayers, $guild1, $guild2, $playersPerGuild);

        return [
            'guild1' => $guild1,
            'guild2' => $guild2,
        ];
    }

    private function fillMinimumComposition(Collection $playersGroupedByClass, Collection &$guild1, Collection &$guild2): void
    {
        $minComposition = [
            'guild1' => [],
            'guild2' => [],
        ];

        foreach (Player::getClasses() as $class) {
            $players = $playersGroupedByClass->get($class, collect());

            if ($this->isRangedClass($class)) {
                $this->assignRangedClass($players, $minComposition);
            } else {
                $this->assignClassToGuilds($players, $minComposition);
            }
        }

        $guild1->push(...$minComposition['guild1']);
        $guild2->push(...$minComposition['guild2']);
    }

    private function isRangedClass(string $class): bool
    {
        return in_array($class, ['mage', 'archer']);
    }

    private function assignRangedClass(Collection $players, array &$minComposition): void
    {
        foreach (['guild1', 'guild2'] as $guild) {
            if (!isset($minComposition[$guild]['ranged']) && $players->isNotEmpty()) {
                $minComposition[$guild]['ranged'] = $players->shift();
            }
        }
    }

    private function assignClassToGuilds(Collection $players, array &$minComposition): void
    {
        foreach (['guild1', 'guild2'] as $guild) {
            if ($players->isNotEmpty()) {
                $minComposition[$guild][] = $players->shift();
            }
        }
    }

    private function getRemainingPlayers(Collection $playersGroupedByClass, Collection $guild1, Collection $guild2): Collection
    {
        return $playersGroupedByClass->flatten(1)->diff($guild1)->diff($guild2);
    }

    private function getMinimumComposition(Collection $playersGroupedByClass): Collection
    {
        $requiredClasses = Player::getClasses();
        $requiredPlayers = collect();

        foreach ($requiredClasses as $class) {
            $player = $playersGroupedByClass->get($class, collect())->shift();
            if ($player) {
                $requiredPlayers->push($player);
            }
        }

        return $requiredPlayers;
    }

    private function balanceRemainingPlayers(Collection $remainingPlayers, Collection &$guild1, Collection &$guild2, int $playersPerGuild): void
    {
        foreach ($remainingPlayers as $player) {
            if ($this->canAddToGuild($guild1, $playersPerGuild)) {
                $guild1->push($player);
                continue;
            }

            if ($this->canAddToGuild($guild2, $playersPerGuild)) {
                $guild2->push($player);
                continue;
            }
        }
    }

    private function canAddToGuild(Collection $guild, int $playersPerGuild): bool
    {
        return $guild->count() < $playersPerGuild;
    }
}
