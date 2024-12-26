<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRpgSessionRequest;
use App\Services\RpgSessionService;

class RpgSessionController extends Controller
{
    protected $service;

    public function __construct(RpgSessionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $rpgSessions = $this->service->getPaginate();

        return view('rpg_sessions.index', [
            'rpgSessions' => $rpgSessions,
        ]);
    }

    public function create()
    {
        return view('rpg_sessions.create');
    }

    public function store(StoreRpgSessionRequest $request)
    {
        $rpgSession = $this->service->createRpgSession($request->validated());

        return redirect()
            ->route('rpg-sessions.index')
            ->with('success', __('messages.success.rpg_session_created', ['name' => $rpgSession->name]));
    }
}
