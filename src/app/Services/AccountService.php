<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\AccountServiceInterface;

class AccountService implements AccountServiceInterface
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getBalance($accountId): ?int
    {
        if (!self::getAccount($accountId)) {
            return null;
        }

        return $this->accountRepository->getBalance($accountId);
    }

    public function getAccount($accountId)
    {
        return $this->accountRepository->getOne($accountId);
    }
}
