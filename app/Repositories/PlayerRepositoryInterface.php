<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PlayerRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): Player;
    public function create(array $data): Player;
    public function update(Player $player, array $data): Player;
    public function delete(Player $player): void;
}