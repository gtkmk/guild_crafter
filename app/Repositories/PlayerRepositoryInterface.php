<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

interface PlayerRepositoryInterface
{
    public function all(): Collection;
    public function find(string $id): Player;
    public function create(array $data): Player;
    public function update(string $id, array $data): Player;
    public function delete(string $id): void;
}