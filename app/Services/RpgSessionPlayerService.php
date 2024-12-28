<?php

namespace App\Services;

use App\Models\Player;
use App\Models\RpgSessionPlayer;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\RpgSessionPlayerRepositoryInterface;
use App\Repositories\RpgSessionRepositoryInterface;
use App\Services\Strategies\BalanceByClassAndXpStrategy;
use App\Services\Validation\GuildValidator;
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
        BalanceByClassAndXpStrategy $balanceByClassAndXpStrategy,
        GuildValidator $guildValidator,
    ) {
        $this->rpgSessionPlayerRepository = $rpgSessionPlayerRepository;
        $this->rpgSessionRepository = $rpgSessionRepository;
        $this->playerRepository = $playerRepository;
        $this->guildValidator = $guildValidator;
        $this->balanceStrategy = $balanceByClassAndXpStrategy;
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
        if ($playersPerGuild < 3) {
            throw new \Exception(__('validation.messages.minimum_players_per_guild', ['min' => 3]));
        }

        $this->validateSessionExistence($sessionId);

        $this->rpgSessionPlayerRepository->resetAssignedGuildsForSession($sessionId);

        $rpgSessionPlayers = $this->rpgSessionPlayerRepository->getRpgSessionPlayersBySessionId($sessionId);
        $players = $rpgSessionPlayers->pluck('Player');

        $this->guildValidator->validate($players, $playersPerGuild);

        $balancedGuilds = $this->balanceStrategy->balance($players, $playersPerGuild);

        $this->assignGuildsToPlayers($rpgSessionPlayers, $balancedGuilds);

        return $balancedGuilds;
    }

    public function assignGuildsToPlayers(Collection $rpgSessionPlayers, array $balancedGuilds): void
    {
        foreach ($balancedGuilds as $guild => $players) {
            foreach ($players as $player) {
                $rpgSessionPlayer = $rpgSessionPlayers->firstWhere('Player', $player);

                if ($rpgSessionPlayer) {
                    $rpgSessionPlayer->assigned_guild = $this->getAssignedGuildNumber($guild);

                    $this->rpgSessionPlayerRepository->updateRecord($rpgSessionPlayer);
                }
            }
        }
    }

    private function getAssignedGuildNumber(string $guild): int
    {
        return $guild === 'guild1' ? 1 : 2;
    }
}