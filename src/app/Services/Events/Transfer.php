<?php

namespace App\Services\Events;

use App\DTO\Event\EventDTO;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;

class Transfer extends Event implements EventInterface
{

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        parent::__construct($accountRepository);
    }


    public function execute(EventDTO $event): ?array
    {
        $origin_account = $this->accountRepository->getOne($event->getOrigin());
        $destination_account = $this->accountRepository->getOne($event->getDestination());
        if ((!$origin_account) OR (!$destination_account)) {
            return null;
        }

        $new_origin_balance = $origin_account["balance"] - $event->getAmount();
        if ($new_origin_balance < 0) {
            return null;
        }

        $new_destination_balance = $destination_account["balance"] + $event->getAmount();
        //TODO: transaction
        $this->accountRepository->updateBalance($event->getOrigin(), $new_origin_balance);
        $this->accountRepository->updateBalance($event->getDestination(), $new_destination_balance);

        return [
            "origin" => [
                'id' => $origin_account["id"],
                'balance' => $new_origin_balance
            ],
            "destination" => [
                'id' => $destination_account['id'],
                'balance' => $new_destination_balance
            ]
        ];
    }
}