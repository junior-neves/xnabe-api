<?php

namespace App\Services\Events;

use App\DTO\Event\EventDTO;
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
    public function execute(EventDTO $event): ?array
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
        //TODO: transaction
        $this->accountRepository->updateBalance($event->getOrigin(), $newOriginBalance);
        $this->accountRepository->updateBalance($event->getDestination(), $newDestinationBalance);

        return [
            "origin" => [
                'id' => $originAccount["id"],
                'balance' => $newOriginBalance
            ],
            "destination" => [
                'id' => $destinationAccount['id'],
                'balance' => $newDestinationBalance
            ]
        ];
    }
}
