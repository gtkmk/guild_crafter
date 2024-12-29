<?php

namespace App\Services;

use App\Models\Player;
use App\Models\RpgSessionPlayer;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\RpgSessionPlayerRepositoryInterface;
use App\Repositories\RpgSessionRepositoryInterface;
use App\Services\Strategies\BalanceByClassAndXpWithGreedyStrategy ;
use App\Services\Validation\GuildValidator;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RpgSessionPlayerService
{
    protected $rpgSessionPlayerRepository;
    protected $rpgSessionRepository;
    protected $playerRepository;
    protected $balanceStrategy;
    private $guildValidator;

    public function __construct(
        RpgSessionPlayerRepositoryInterface $rpgSessionPlayerRepository,
        RpgSessionRepositoryInterface $rpgSessionRepository,
        PlayerRepositoryInterface $playerRepository,
        BalanceByClassAndXpWithGreedyStrategy  $balanceByClassAndXpWithGreedyStrategy ,
        GuildValidator $guildValidator,
    ) {
        $this->rpgSessionPlayerRepository = $rpgSessionPlayerRepository;
        $this->rpgSessionRepository = $rpgSessionRepository;
        $this->playerRepository = $playerRepository;
        $this->guildValidator = $guildValidator;
        $this->balanceStrategy = $balanceByClassAndXpWithGreedyStrategy ;
    }

    public function getUnconfirmedPlayers(string $sessionId, int $perPage = 15): LengthAwarePaginator
    {
        $this->validateSessionExistence($sessionId);

        $players = $this->rpgSessionPlayerRepository->getNotConfirmedPlayers($sessionId, $perPage);
        Player::translatePlayerClasses($players);

        return $players;
    }

    private function validateSessionExistence(string $sessionId): void
    {
        $this->rpgSessionRepository->find($sessionId);
    }

    private function validatePlayerExistence(string $playerId): void
    {
        $this->playerRepository->find($playerId);
    }

    public function validateSessionAndPlayerExistence(string $sessionId, string $playerId): void
    {
        $this->validateSessionExistence($sessionId);
        $this->validatePlayerExistence($playerId);
    }

    public function isPlayerAlreadyConfirmed(string $sessionId, string $playerId): bool
    {
        return $this->rpgSessionPlayerRepository->isPlayerAlreadyConfirmedForSession($sessionId, $playerId);
    }

    public function confirmPlayerPresence(string $sessionId, string $playerId)
    {
        $rpgSessionPlayer = $this->createRpgSessionPlayerInstance($sessionId, $playerId);

        return $this->savePlayerSessionAssociation($rpgSessionPlayer);
    }

    private function createRpgSessionPlayerInstance(string $sessionId, string $playerId): RpgSessionPlayer
    {
        $rpgSessionPlayer = new RpgSessionPlayer();
        $rpgSessionPlayer->rpg_session_id = $sessionId;
        $rpgSessionPlayer->player_id = $playerId;
        $rpgSessionPlayer->assigned_guild = null;

        return $rpgSessionPlayer;
    }

    private function savePlayerSessionAssociation(RpgSessionPlayer $rpgSessionPlayer): RpgSessionPlayer
    {
        return $this->rpgSessionPlayerRepository->createPlayerSessionAssociation($rpgSessionPlayer);
    }

    public function sessionHasPlayers(string $sessionId): bool
    {
        return $this->rpgSessionPlayerRepository->existsSessionPlayerBySessionId($sessionId);
    }

    public function getGuildPlayerGroups(string $sessionId): Collection
    {
        $rpgSessionPlayers = $this->rpgSessionPlayerRepository->getRpgSessionPlayersBySessionId($sessionId);

        Player::translatePlayerClasses($rpgSessionPlayers->pluck('player'));
        $this->assignDefaultGuild($rpgSessionPlayers);

        return $this->groupPlayersByGuild($rpgSessionPlayers);
    }

    private function assignDefaultGuild(Collection $sessionPlayers): void
    {
        $sessionPlayers->each(function ($sessionPlayer) {
            if (empty($sessionPlayer->assigned_guild)) {
                $sessionPlayer->assigned_guild = 'no_guild';
            }
        });
    }

    private function groupPlayersByGuild(Collection $sessionPlayers): Collection
    {
        return $sessionPlayers->groupBy('assigned_guild');
    }

    public function assignPlayersToGuilds(string $sessionId, int $playersPerGuild): array
    {
        $this->validateSessionExistence($sessionId);

        $players = $this->fetchSessionPlayers($sessionId);

        $this->guildValidator->validate($players, $playersPerGuild);

        $this->resetSessionGuildAssignments($sessionId);

        $balancedGuilds = $this->balancePlayersIntoGuilds($players, $playersPerGuild);

        $this->persistGuildAssignments($sessionId, $players, $balancedGuilds);

        return $balancedGuilds;
    }

    private function fetchSessionPlayers(string $sessionId): Collection
    {
        $rpgSessionPlayers = $this->rpgSessionPlayerRepository->getRpgSessionPlayersBySessionId($sessionId);
        return $rpgSessionPlayers->pluck('Player');
    }

    private function resetSessionGuildAssignments(string $sessionId): void
    {
        $this->rpgSessionPlayerRepository->resetAssignedGuildsForSession($sessionId);
    }

    private function balancePlayersIntoGuilds(Collection $players, int $playersPerGuild): array
    {
        return $this->balanceStrategy->balance($players, $playersPerGuild);
    }

    private function persistGuildAssignments(string $sessionId, Collection $players, array $balancedGuilds): void
    {
        foreach ($balancedGuilds as $guildKey => $assignedPlayers) {
            $guildNumber = $this->defineGuildNumber($guildKey);

            foreach ($assignedPlayers as $player) {
                $this->assignPlayerToGuild($sessionId, $player, $guildNumber);
            }
        }
    }

    private function defineGuildNumber(string $guildKey): int
    {
        return match ($guildKey) {
            'guild1' => 1,
            'guild2' => 2,
        };
    }

    private function assignPlayerToGuild(string $sessionId, $player, int $guildNumber): void
    {
        $sessionPlayer = $this->rpgSessionPlayerRepository->findPlayerInSession($sessionId, $player);

        if (!$sessionPlayer) {
            throw new Exception(__('validation.messages.player_not_found_in_session', ['player' => $player->name]));
        }

        $sessionPlayer->assigned_guild = $guildNumber;
        $this->rpgSessionPlayerRepository->updateRecord($sessionPlayer);
    }
}