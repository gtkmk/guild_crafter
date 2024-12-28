<?php

namespace App\Http\Controllers;

use App\Services\RpgSessionPlayerService;
use Exception;
use Illuminate\Http\Request;

class RpgSessionPlayerController extends Controller
{
    protected $service;

    public function __construct(RpgSessionPlayerService $service)
    {
        $this->service = $service;
    }

    public function showAvailablePlayers(string $id)
    {
        $rpgSessions = $this->service->getUnconfirmedPlayers($id);

        return view('rpg_session_players.available_players', [
            'notConfirmedPlayers' => $rpgSessions,
            'rpgSessionId' => $id,
        ]);
    }

    public function confirmPresence(string $rpgSessionId, string $playerId)
    {
        $this->service->validateSessionAndPlayerExistence($rpgSessionId, $playerId);

        if ($this->service->isPlayerAlreadyConfirmed($rpgSessionId, $playerId)) {
            return redirect()
                ->route('rpg-session-players.available_players', $rpgSessionId)
                ->withErrors(__('validation.messages.player_already_confirmed'));
        }

        $this->service->confirmPlayerPresence($rpgSessionId, $playerId);

        return redirect()
            ->route('rpg-session-players.available_players', $rpgSessionId)
            ->with('success', __('messages.success.player_confirmed'));
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
            'rpgSessionId' => $rpgSessionId,
        ]);
    }

    public function assignGuilds(string $rpgSessionId, Request $request)
    {
        try {
            $playersPerGuild = $request->input('playersPerGuild');

            $this->service->assignPlayersToGuilds($rpgSessionId, $playersPerGuild);

            return redirect()
                ->route('rpg-session-players.guilds', $rpgSessionId)
                ->with('success', __('messages.success.player_confirmed'));
        } catch (Exception $e) {
            return redirect()
                ->route('rpg-session-players.guilds', $rpgSessionId)
                ->withErrors([
                    'session' => __($e->getMessage()),
                ]);
        }
    }
}
