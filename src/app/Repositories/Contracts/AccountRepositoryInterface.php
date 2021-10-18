<?php

namespace App\Repositories\Contracts;

interface AccountRepositoryInterface
{
    public function create($account_id, $initial_balance);

}