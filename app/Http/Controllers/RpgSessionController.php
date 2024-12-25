<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('players.create');
    }
}
