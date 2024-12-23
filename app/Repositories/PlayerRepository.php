<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function listPlayersWithPagination(int $perPage = 15): LengthAwarePaginator
    {
        return Player::paginate($perPage);
    }

    public function find(string $id): Player
    {
        return Player::findOrFail($id);
    }

    public function create(array $data): Player
    {
        return Player::create($data);
    }

    public function update(string $id, array $data): Player
    {
        $player = $this->find($id);
        $player->update($data);
        return $player;
    }

    public function delete(string $id): void
    {
        $player = $this->find($id);
        $player->delete();
    }
}
