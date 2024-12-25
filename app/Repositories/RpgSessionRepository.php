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

    public function find(string $id): RpgSession
    {
        return RpgSession::findOrFail($id);
    }

    public function create(array $data): RpgSession
    {
        return RpgSession::create($data);
    }

    public function update(RpgSession $rpgSession, array $data): RpgSession
    {
        $rpgSession->update($data);

        return $rpgSession;
    }

    public function delete(RpgSession $rpgSession): void
    {
        $rpgSession->delete();
    }

    public function existsByName(string $name): bool
    {
        return RpgSession::where('name', $name)->exists();
    }
}
