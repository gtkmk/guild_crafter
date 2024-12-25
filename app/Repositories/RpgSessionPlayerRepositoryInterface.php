<?php

namespace App\Repositories;

use App\Models\RpgSession;
use App\Models\RpgSessionPlayer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RpgSessionPlayerRepositoryInterface
{
    public function getNotConfirmedPlayers(string $id, int $perPage = 15): LengthAwarePaginator;
    public function isPlayerAlreadyConfirmedForSession(string $rpgSessionId, string $playerId): bool;
    public function createPlayerSessionAssociation(RpgSessionPlayer $rpgSessionPlayer): RpgSessionPlayer;
}