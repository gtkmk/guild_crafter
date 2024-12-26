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
        $rpgSessions = $this->service->getUnconfirmedPlayers($id);

        return view('rpg_session_players.available_players', [
            'notConfirmedPlayers' => $rpgSessions,
            'rpgSessionId' => $id,
        ]);
    }

    public function confirmPresence(string $rpgSessionId, string $playerId)
    {
        try {
            $this->service->confirmPlayerPresence($rpgSessionId, $playerId);

            return redirect()
                ->route('rpg-session-players.available_players', $rpgSessionId)
                ->with('success', __('messages.success.player_confirmed'));
        } catch (\Exception $exception) {
            return redirect()
                ->route('rpg-session-players.available_players', $rpgSessionId)
                ->withErrors($exception->getMessage());
        }
    }

    public function guildsIndex(string $rpgSessionId)
    {
        if (!$this->service->sessionHasPlayers($rpgSessionId)) {
            return redirect()
                ->route('rpg-sessions.index')
                ->withErrors([
                    'session' => __('validation.messages.session_has_no_players'),
                ]);
        }

        $guildPlayerGroups = $this->service->getGuildPlayerGroups($rpgSessionId);

        return view('rpg_session_players.guilds_index', [
            'guildPlayerGroups' => $guildPlayerGroups,
        ]);
    }
}
