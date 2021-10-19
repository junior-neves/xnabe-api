<?php

namespace App\Services\Contracts;

interface AccountServiceInterface
{
    public function getBalance($account_id): ?int;

    public function getAccount($account_id);
}
