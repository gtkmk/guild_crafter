<?php

namespace App\Http\Controllers;

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
        $players = $this->service->getPaginate();

        return view('players.index', [
            'players' => $players,
        ]);
    }

    public function create()
    {
        return view('players.create');
    }

    public function store(StorePlayerRequest $request)
    {
        $player = $this->service->createPlayer($request->validated());

        return redirect()
            ->route('players.index')
            ->with('success', __('messages.success.player_created', ['name' => $player->name]));
    }

    public function edit(string $id)
    {
        $player = $this->service->getPlayer($id);

        return view('players.edit', [
            'player' => $player,
        ]);
    }

    public function update(StorePlayerRequest $request, string $id)
    {
        $player = $this->service->updatePlayer($id, $request->validated());

        return redirect()
            ->route('players.index')
            ->with('success', __('messages.success.player_updated', ['name' => $player->name]));
    }
}
