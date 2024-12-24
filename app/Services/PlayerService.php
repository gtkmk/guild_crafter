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
        dd("aqui");
        return $this->repository->create($data);
    }
}
