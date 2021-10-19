<?php

namespace App\Services\Events;

use App\DTO\Event\EventDTO;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;

class Deposit extends Event implements EventInterface
{

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        parent::__construct($accountRepository);
    }


    public function execute(EventDTO $event): array
    {
        $account = $this->accountRepository->getOne($event->getDestination());
        if (!$account) {
            $this->accountRepository->create($event->getDestination(), 0);
            $account = $this->accountRepository->getOne($event->getDestination());
        }

        $new_balance = $account["balance"] + $event->getAmount();
        $this->accountRepository->updateBalance($event->getDestination(), $new_balance);

        return ["destination" => [
            'id' => $event->getDestination(),
            'balance' => $new_balance
        ]];
    }

}