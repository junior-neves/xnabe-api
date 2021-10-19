<?php

namespace App\Services\Events;

use App\DTO\Event\EventDTO;
use App\Exceptions\Account\AccountNotFoundException;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;

class Withdraw extends Event implements EventInterface
{

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        parent::__construct($accountRepository);
    }

    public function execute(EventDTO $event): ?array
    {
        $account = $this->accountRepository->getOne($event->getOrigin());
        if (!$account) {
            throw new AccountNotFoundException("Account not found");
        }

        $new_balance = $account["balance"] - $event->getAmount();
        if ($new_balance < 0) {
            return null;
        }

        $this->accountRepository->updateBalance($event->getOrigin(), $new_balance);


        return ["origin" => [
            'id' => $event->getOrigin(),
            'balance' => $new_balance
        ]];
    }
}