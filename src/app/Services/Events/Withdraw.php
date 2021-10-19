<?php

namespace App\Services\Events;

use App\DTO\Event\EventDTO;
use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Account\InsufficientBalanceException;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;

class Withdraw extends Event implements EventInterface
{
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        parent::__construct($accountRepository);
    }

    /**
     * @throws AccountNotFoundException
     * @throws InsufficientBalanceException
     */
    public function execute(EventDTO $event): ?array
    {
        $account = $this->accountRepository->getOne($event->getOrigin());
        if (!$account) {
            throw new AccountNotFoundException();
        }

        $newBalance = $account["balance"] - $event->getAmount();
        if ($newBalance < 0) {
            throw new InsufficientBalanceException();
        }

        $this->accountRepository->updateBalance($event->getOrigin(), $newBalance);


        return ["origin" => [
            'id' => $event->getOrigin(),
            'balance' => $newBalance
        ]];
    }
}
