<?php

namespace App\Repositories\Contracts;

interface AccountRepositoryInterface
{
    public function create($accountId, $initialBalance): bool;

    public function updateBalance($accountId, $balance): bool;

    public function getOne($accountId): ?array;

    public function getBalance($accountId): int;
}
