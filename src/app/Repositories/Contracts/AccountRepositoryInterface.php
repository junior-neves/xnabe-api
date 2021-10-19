<?php

namespace App\Repositories\Contracts;

interface AccountRepositoryInterface
{
    public function create($account_id, $initial_balance): bool;

    public function updateBalance($account_id, $balance): bool;

    public function getOne($account_id): ?array;

    public function getBalance($account_id): int;
}
