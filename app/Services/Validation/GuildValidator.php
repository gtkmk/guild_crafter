<?php

namespace App\Services\Validation;

use App\Models\Player;
use Illuminate\Support\Collection;

class GuildValidator
{
    public function validate(Collection $players, int $playersPerGuild): void
    {
        $totalPlayers = $players->count();
        $classCounts = $this->countPlayerClasses($players);        

        $guildCount = $this->determineGuildCount($totalPlayers, $playersPerGuild);

        $this->validateClassRequirements($classCounts, $guildCount);
    }

    private function determineGuildCount(int $totalPlayers, int $playersPerGuild): int
    {
        return $totalPlayers < 2 * $playersPerGuild ? 1 : 2;
    }

    private function validateClassRequirements(array $classCounts, int $requiredCount): void
    {
        $this->validateMinimumCount($classCounts['cleric'], $requiredCount, 'cleric');
        $this->validateMinimumCount($classCounts['warrior'], $requiredCount, 'warrior');

        $mageAndArcherCount = $classCounts['mage'] + $classCounts['archer'];
        if ($mageAndArcherCount < $requiredCount) {
            throw new \Exception(__('validation.messages.insufficient_players', [
                'class' => 'arqueiro ou mago',
            ]));
        }
    }

    private function validateMinimumCount(int $actualCount, int $requiredCount, string $className): void
    {
        if ($actualCount < $requiredCount) {
            throw new \Exception(__('validation.messages.insufficient_players', [
                'class' => Player::translateClass($className),
            ]));
        }
    }

    private function countPlayerClasses(Collection $players): array
    {
        return $players->groupBy('class')->map->count()->toArray();
    }
}