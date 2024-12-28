<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\RpgSessionPlayer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RpgSessionPlayerRepository implements RpgSessionPlayerRepositoryInterface
{
    public function getNotConfirmedPlayers(string $sessionId, int $perPage = 15): LengthAwarePaginator
    {
        return Player::whereNotIn('id', function ($query) use ($sessionId) {
            $query->select('player_id')
                ->from('rpg_session_player')
                ->where('rpg_session_id', $sessionId);
            })
            ->paginate($perPage);
    }

    public function isPlayerAlreadyConfirmedForSession(string $sessionId, string $playerId): bool
    {
        return RpgSessionPlayer::where('rpg_session_id', $sessionId)
            ->where('player_id', $playerId)
            ->exists();
    }


    public function createPlayerSessionAssociation(RpgSessionPlayer $rpgSessionPlayer): RpgSessionPlayer
    {
        $rpgSessionPlayer->save();
        return $rpgSessionPlayer;
    }

    public function existsSessionPlayerBySessionId(string $sessionId): bool
    {
        return RpgSessionPlayer::where('rpg_session_id', $sessionId)->exists();
    }

    public function getRpgSessionPlayersBySessionId(string $sessionId): Collection
    {
        return RpgSessionPlayer::with('player')
            ->where('rpg_session_id', $sessionId)
            ->get();
    }

    public function resetAssignedGuildsForSession(string $sessionId): void
    {
        RpgSessionPlayer::where('rpg_session_id', $sessionId)
            ->update(['assigned_guild' => null]);
    }

    public function updateRecord(RpgSessionPlayer $rpgSessionPlayer): void
    {
        $rpgSessionPlayer->save();
    }
}
