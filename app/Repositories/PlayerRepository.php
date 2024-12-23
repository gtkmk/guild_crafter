<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function all(): Collection
    {
        return Player::all();
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
