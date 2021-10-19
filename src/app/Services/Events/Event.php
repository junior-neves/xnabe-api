<?php

namespace App\Services\Events;

use App\Repositories\Contracts\AccountRepositoryInterface;

abstract class Event
{
    protected AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }
}
