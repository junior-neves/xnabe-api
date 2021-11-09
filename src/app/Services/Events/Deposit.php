<?php

namespace App\Services\Events;

use App\DTO\Account\AccountDTO;
use App\DTO\Event\EventDTO;
use App\DTO\Event\EventReturnDTO;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;

class Deposit extends Event implements EventInterface
{
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        parent::__construct($accountRepository);
    }

    public function execute(EventDTO $event): ?EventReturnDTO
    {
        $account = $this->accountRepository->getOne($event->getDestination());
        if (!$account) {
            $this->accountRepository->create($event->getDestination(), 0);
            $account = $this->accountRepository->getOne($event->getDestination());
        }

        $newBalance = $account["balance"] + $event->getAmount();
        $this->accountRepository->updateBalance($event->getDestination(), $newBalance);

        $destination = (new AccountDTO())
            ->setId($event->getDestination())
            ->setBalance($newBalance);

        return (new EventReturnDTO())
            ->setDestination($destination);
    }
}
