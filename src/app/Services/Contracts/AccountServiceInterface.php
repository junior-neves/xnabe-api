<?php

namespace App\Services\Contracts;

interface AccountServiceInterface
{
    public function getBalance($accountId): ?int;

    public function getAccount($accountId);
}
