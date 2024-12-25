<?php

namespace App\Repositories;

use App\Models\RpgSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RpgSessionRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(string $id): RpgSession;
    public function create(array $data): RpgSession;
    public function update(RpgSession $player, array $data): RpgSession;
    public function delete(RpgSession $player): void;
}