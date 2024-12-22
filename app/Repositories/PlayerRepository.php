<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository implements PlayerRepositoryInterface
{
    public function all()
    {
        return Player::all();
    }

    public function find(string $id)
    {
        return Player::findOrFail($id);
    }

    public function create(array $data)
    {
        return Player::create($data);
    }

    public function update(string $id, array $data)
    {
        $player = $this->find($id);
        $player->update($data);
        return $player;
    }

    public function delete(string $id)
    {
        $player = $this->find($id);
        $player->delete();
    }
}
