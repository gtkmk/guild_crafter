<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Http\Requests\PlayerRequest;
use App\Repositories\PlayerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{
    protected $repository;

    public function __construct(PlayerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $players = $this->repository->all();

        return view('players.index', [
            'players' => $players,
        ]);
    }

    public function create()
    {
        return view('players.create');
    }

    public function store(PlayerRequest $request)
    {
        $this->repository->create($request->validated());
        return redirect()->route('players.index')->with('success', 'Jogador criado com sucesso!');
    }
}
