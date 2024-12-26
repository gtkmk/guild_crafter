<?php

namespace App\Services;

use App\Exceptions\PlayerAlreadyConfirmedException;
use App\Models\Player;
use App\Models\RpgSessionPlayer;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\RpgSessionPlayerRepositoryInterface;
use App\Repositories\RpgSessionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RpgSessionPlayerService
{
    protected $rpgSessionPlayerRepository;
    protected $rpgSessionRepository;
    protected $playerRepository;

    public function __construct(
        RpgSessionPlayerRepositoryInterface $rpgSessionPlayerRepository,
        RpgSessionRepositoryInterface $rpgSessionRepository,
        PlayerRepositoryInterface $playerRepository
    ) {
        $this->rpgSessionPlayerRepository = $rpgSessionPlayerRepository;
        $this->rpgSessionRepository = $rpgSessionRepository;
        $this->playerRepository = $playerRepository;
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
        $rpgSessionPlayers = $this->rpgSessionPlayerRepository->getPlayersBySessionId($sessionId);
    
        $this->translatePlayerClasses($rpgSessionPlayers);
        $this->assignDefaultGuild($rpgSessionPlayers);
    
        return $this->groupPlayersByGuild($rpgSessionPlayers);
    }
    
    private function translatePlayerClasses(Collection $sessionPlayers): void
    {
        Player::translatePlayerClasses($sessionPlayers->pluck('player'));
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
}