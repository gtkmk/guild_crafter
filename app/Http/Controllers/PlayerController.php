<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerRequest;
use App\Http\Requests\StorePlayerRequest;
use App\Services\PlayerService;

class PlayerController extends Controller
{
    protected $service;

    public function __construct(PlayerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $players = $this->service->listPlayers();

        return view('players.index', [
            'players' => $players,
        ]);
    }

    public function create()
    {
        return view('players.create');
    }

    public function store(StorePlayerRequest $request): string
    {
        $this->service->createPlayer($request->validated());

        return redirect()
            ->route('players.index')
            ->with('success', 'Jogador criado com sucesso!');
    }
}
