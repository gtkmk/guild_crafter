<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlayerRepositoryInterface
{
    public function listPlayersWithPagination(int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): Player;
    public function create(array $data): Player;
    public function update(string $id, array $data): Player;
    public function delete(string $id): void;
}