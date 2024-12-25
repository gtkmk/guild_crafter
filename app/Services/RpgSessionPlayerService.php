<?php

namespace App\Services;

use App\Exceptions\PlayerAlreadyConfirmedException;
use App\Models\RpgSessionPlayer;
use App\Repositories\PlayerRepositoryInterface;
use App\Repositories\RpgSessionPlayerRepositoryInterface;
use App\Repositories\RpgSessionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function findNotConfirmedPlayers(string $sessionId, int $perPage = 15): LengthAwarePaginator
    {
        $this->rpgSessionRepository->find($sessionId);

        return $this->rpgSessionPlayerRepository->getNotConfirmedPlayers($sessionId, $perPage);
    }

    public function confirmPlayerPresence(string $sessionId, string $playerId)
    {
        $this->validateSessionAndPlayer($sessionId, $playerId);
        $this->checkIfPlayerAlreadyConfirmed($sessionId, $playerId);

        $rpgSessionPlayer = $this->createRpgSessionPlayerInstance($sessionId, $playerId);

        return $this->savePlayerSessionAssociation($rpgSessionPlayer);
    }

    private function validateSessionAndPlayer(string $sessionId, string $playerId): void
    {
        $this->rpgSessionRepository->find($sessionId);
        $this->playerRepository->find($playerId);
    }

    private function checkIfPlayerAlreadyConfirmed(string $sessionId, string $playerId): void
    {
        if ($this->rpgSessionPlayerRepository->isPlayerAlreadyConfirmedForSession($sessionId, $playerId)) {
            throw new \Exception(__('validation.messages.player_already_confirmed'));
        }
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
}