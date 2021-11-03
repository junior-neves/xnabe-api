<?php

namespace App\Services\Events;

use App\DTO\Account\AccountDTO;
use App\DTO\Event\EventDTO;
use App\DTO\Event\EventReturnDTO;
use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Account\InsufficientBalanceException;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;

class Transfer extends Event implements EventInterface
{
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        parent::__construct($accountRepository);
    }

    /**
     * @throws AccountNotFoundException
     * @throws InsufficientBalanceException
     */
    public function execute(EventDTO $event): ?EventReturnDTO
    {
        $originAccount = $this->accountRepository->getOne($event->getOrigin());
        $destinationAccount = $this->accountRepository->getOne($event->getDestination());
        if ((!$originAccount) or (!$destinationAccount)) {
            throw new AccountNotFoundException();
        }

        $newOriginBalance = $originAccount["balance"] - $event->getAmount();
        if ($newOriginBalance < 0) {
            throw new InsufficientBalanceException();
        }

        $newDestinationBalance = $destinationAccount["balance"] + $event->getAmount();

        $this->accountRepository->updateBalance($event->getOrigin(), $newOriginBalance);
        $this->accountRepository->updateBalance($event->getDestination(), $newDestinationBalance);

        $origin = (new AccountDTO())
            ->setId($event->getOrigin())
            ->setBalance($newOriginBalance);

        $destination = (new AccountDTO())
            ->setId($event->getDestination())
            ->setBalance($newDestinationBalance);

        return (new EventReturnDTO())
            ->setOrigin($origin)
            ->setDestination($destination);
    }
}
