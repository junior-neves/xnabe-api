<?php

namespace App\Services\Factories;

use App\Exceptions\Event\EventFactoryNotAllowedException;
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

    /**
     * @throws EventFactoryNotAllowedException
     */
    public function factory(string $type): EventInterface
    {

        $accountRepository = new AccountRepositoryPDO();

        if (! array_key_exists($type, self::ALLOWED_EVENTS)) {
            throw new EventFactoryNotAllowedException();
        }

        $eventClass = self::ALLOWED_EVENTS[$type];
        return new $eventClass($accountRepository);
    }
}
