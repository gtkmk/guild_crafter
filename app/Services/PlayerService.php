<?php

namespace App\Services;

use App\Models\Player;
use App\Repositories\PlayerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlayerService
{
    protected $repository;

    public function __construct(PlayerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function createPlayer(array $data)
    {
        $playerData = [
            'name' => $data['name'],
            'class' => $data['class'],
            'xp' => $data['xp'],
        ];

        return $this->repository->create($playerData);
    }

    public function getPlayer(string $id): Player
    {
        return $this->repository->find($id);
    }

    public function updatePlayer(string $id, array $data): Player
    {
        $player = $this->getPlayer($id);

        return $this->repository->update($player, $data);
    }
}
