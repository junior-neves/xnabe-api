<?php

namespace App\Services\Factories;

use App\Repositories\AccountRepositoryPDO;
use App\Services\Contracts\EventInterface;
use App\Services\Events\Deposit;
use App\Services\Events\Transfer;
use App\Services\Events\Withdraw;

class EventFactory
{
    private const ALLOWED_EVENTS = [
        "deposit" => Deposit::class,
        "withdraw" => Withdraw::class,
        "transfer" => Transfer::class
    ];

    public function factory(string $type) : EventInterface
    {

        $accountRepository = new AccountRepositoryPDO();

        if ( ! array_key_exists($type,self::ALLOWED_EVENTS ) ) {
            //exception
        }

        $eventClass = self::ALLOWED_EVENTS[$type];
        return new $eventClass($accountRepository);

    }

}