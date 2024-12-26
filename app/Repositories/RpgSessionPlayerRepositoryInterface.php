<?php

namespace App\Repositories;

use App\Models\RpgSession;
use App\Models\RpgSessionPlayer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RpgSessionPlayerRepositoryInterface
{
    public function getNotConfirmedPlayers(string $id, int $perPage = 15): LengthAwarePaginator;
    public function isPlayerAlreadyConfirmedForSession(string $rpgSessionId, string $playerId): bool;
    public function createPlayerSessionAssociation(RpgSessionPlayer $rpgSessionPlayer): RpgSessionPlayer;
    public function existsSessionPlayerBySessionId(string $sessionId): bool;
    public function getRpgSessionPlayersBySessionId(string $sessionId): Collection;
    public function updateRecord(RpgSessionPlayer $rpgSessionPlayer): void;
}