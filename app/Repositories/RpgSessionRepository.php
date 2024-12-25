<?php

namespace App\Repositories;

use App\Models\RpgSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RpgSessionRepository implements RpgSessionRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return RpgSession::paginate($perPage);
    }

    public function create(array $data): RpgSession
    {
        return RpgSession::create($data);
    }

    public function find(string $id): RpgSession
    {
        return RpgSession::findOrFail($id);
    }
}
