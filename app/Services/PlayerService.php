<?php

namespace App\Services;

use App\Repositories\PlayerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlayerService
{
    protected $repository;

    public function __construct(PlayerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listPlayers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->listPlayersWithPagination($perPage);
    }

    public function createPlayer(array $data)
    {
        if (isset($data['name']) && strlen($data['name']) < 3) {
            throw new \Exception('O nome do jogador deve ter pelo menos 3 caracteres.');
        }

        return $this->repository->create($data);
    }
}
