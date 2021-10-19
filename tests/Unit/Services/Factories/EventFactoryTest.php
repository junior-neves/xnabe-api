<?php

namespace Unit\Services\Factories;

use App\Exceptions\Event\EventFactoryNotAllowedException;
use App\Services\Events\Deposit;
use App\Services\Events\Transfer;
use App\Services\Events\Withdraw;
use App\Services\Factories\EventFactory;
use PHPUnit\Framework\TestCase;

class EventFactoryTest extends TestCase
{

    private EventFactory $eventFactory;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->eventFactory = new EventFactory();
    }

    public function testGetDepositEventClass()
    {
        $factory = $this->eventFactory->factory('deposit');

        $this->assertInstanceOf(Deposit::class, $factory);
    }

    public function testGetWithdrawEventClass()
    {
        $factory = $this->eventFactory->factory('withdraw');

        $this->assertInstanceOf(Withdraw::class, $factory);
    }

    public function testGetTransferEventClass()
    {
        $factory = $this->eventFactory->factory('transfer');

        $this->assertInstanceOf(Transfer::class, $factory);
    }

    public function testGetNotAllowedEventClass()
    {
        $this->expectException(EventFactoryNotAllowedException::class);

        $factory = $this->eventFactory->factory('notAllowedEvent');
    }
}
