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

    public function getBalance($account_id): ?int
    {
        if (!self::getAccount($account_id)) {
            return null;
        }

        return $this->accountRepository->getBalance($account_id);
    }

    public function getAccount($account_id)
    {
        return $this->accountRepository->getOne($account_id);
    }
}
