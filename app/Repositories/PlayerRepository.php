<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
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

    public function update(Player $player, array $data): Player
    {
        $player->update($data);

        return $player;
    }

    public function delete(Player $player): void
    {
        $player->delete();
    }
}
