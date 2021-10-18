<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventServiceInterface;

class EventService implements EventServiceInterface
{
    private AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function makeDeposit($account_id, $amount) {
        $account = self::getAccount($account_id);
        if (!$account) {
            $this->accountRepository->create($account_id, $amount);
        } else {
            $new_balance = $account["balance"] + $amount;
            $this->accountRepository->updateBalance($account_id, $new_balance);
        }

        $account = self::getAccount($account_id);
        return ["destination" => $account];
    }

    public function makeWithdraw($account_id, $amount): ?array
    {
        $account = self::getAccount($account_id);
        if (!$account) {
            return null;
        }

        $new_balance = $account["balance"] - $amount;
        if ($new_balance < 0) {
            return null;
        }

        $this->accountRepository->updateBalance($account_id, $new_balance);

        $account = self::getAccount($account_id);
        return ["origin" => $account];
    }

    public function makeTransfer($origin_account_id, $destination_account_id, $amount) {
        $origin_account = self::getAccount($origin_account_id);
        $destination_account = self::getAccount($destination_account_id);
        if ((!$origin_account) OR (!$destination_account)) {
            return null;
        }

        $new_origin_balance = $origin_account["balance"] - $amount;
        if ($new_origin_balance < 0) {
            return null;
        }

        $new_destination_balance = $destination_account["balance"] + $amount;

        $this->accountRepository->updateBalance($origin_account_id, $new_origin_balance);
        $this->accountRepository->updateBalance($destination_account_id, $new_destination_balance);

        $origin_account = self::getAccount($origin_account_id);
        $destination_account = self::getAccount($destination_account_id);
        return ["origin" => $origin_account, "destination" => $destination_account];
    }

    public function getAccount($id_account) {
        $account = $this->accountRepository->getOne($id_account);
        if ($account) {
            $account["balance"] = (int)$account["balance"];
        }
        return $account;
    }

}