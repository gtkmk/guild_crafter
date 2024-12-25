<?php

namespace App\Services;

use App\Models\RpgSession;
use App\Repositories\RpgSessionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RpgSessionService
{
    protected $repository;

    public function __construct(RpgSessionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate(int $perPage = 15): LengthAwarePaginator
    {
        $RpgSessions = $this->repository->paginate($perPage);
        $this->translatePlayerClasses($RpgSessions);

        return $RpgSessions;
    }

    private function translatePlayerClasses(LengthAwarePaginator $rpgSessions): void
    {
        foreach ($rpgSessions as $rpgSession) {
            $rpgSession->campaign_date = $rpgSession->getFormattedCampaignDate();
        }
    }

    public function createRpgSession(array $data)
    {
        $rpgSessionData = [
            'name' => $data['name'],
            'campaign_date' => $data['campaign_date'],
        ];

        return $this->repository->create($rpgSessionData);
    }
}