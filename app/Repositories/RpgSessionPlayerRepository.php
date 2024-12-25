<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\RpgSessionPlayer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RpgSessionPlayerRepository implements RpgSessionPlayerRepositoryInterface
{
    public function getNotConfirmedPlayers(string $sessionId, int $perPage = 15): LengthAwarePaginator
    {
        return Player::whereNotIn('id', function ($query) use ($sessionId) {
            $query->select('player_id')
                  ->from('rpg_session_player')
                  ->where('rpg_session_id', $sessionId);
        })->paginate($perPage);
    }

    public function isPlayerAlreadyConfirmedForSession(string $rpgSessionId, string $playerId): bool
    {
        return RpgSessionPlayer::where('rpg_session_id', $rpgSessionId)
                                ->where('player_id', $playerId)
                                ->exists();
    }

    public function createPlayerSessionAssociation(RpgSessionPlayer $rpgSessionPlayer): RpgSessionPlayer
    {
        $rpgSessionPlayer->save();
        return $rpgSessionPlayer;
    }
}
