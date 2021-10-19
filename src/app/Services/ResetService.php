<?php

namespace App\Services;

use App\Repositories\Contracts\ResetRepositoryInterface;

class ResetService
{
    private ResetRepositoryInterface $resetRepository;

    public function __construct(ResetRepositoryInterface $resetRepository)
    {
        $this->resetRepository = $resetRepository;
    }

    public function reset(): void
    {
        $this->resetRepository->reset();
        $this->resetRepository->create();
    }
}
