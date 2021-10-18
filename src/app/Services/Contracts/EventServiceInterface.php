<?php

namespace App\Services\Contracts;

interface EventServiceInterface
{
    public function makeDeposit($account_id, $amount);

    public function makeWithdraw($account_id, $amount): ?array;

    public function makeTransfer($origin_account_id, $destination_account_id, $amount);

    public function getAccount($id_account);
}