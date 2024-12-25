<?php

namespace App\Http\Controllers;

use App\Services\RpgSessionPlayerService;
use Illuminate\Http\Request;

class RpgSessionPlayerController extends Controller
{
    protected $service;

    public function __construct(RpgSessionPlayerService $service)
    {
        $this->service = $service;
    }

    public function listAvailablePlayersForSession(string $id)
    {
        $rpgSessions = $this->service->findNotConfirmedPlayers($id);

        return view('rpg_session_players.index', [
            'notConfirmedPlayers' => $rpgSessions,
            'rpgSessionId' => $id,
        ]);
    }

    public function confirmPresence(string $rpgSessionId, string $playerId)
    {
        try {
            $this->service->confirmPlayerPresence($rpgSessionId, $playerId);

            return redirect()
                ->route('rpg-session-players.index', $rpgSessionId)
                ->with('success', 'Jogador confirmado para a sessão!');
        } catch (\Exception $exception) {
            return redirect()
                ->route('rpg-session-players.index', $rpgSessionId)
                ->withErrors($exception->getMessage());
        }
    }
}
