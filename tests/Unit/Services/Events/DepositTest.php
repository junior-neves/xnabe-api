<?php

namespace Unit\Services\Events;

use App\DTO\Account\AccountDTO;
use App\DTO\Event\EventReturnDTO;
use App\Mappers\Contracts\EventMapperInterface;
use App\Mappers\EventMapper;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;
use App\Services\Events\Deposit;
use PHPUnit\Framework\TestCase;

class DepositTest extends TestCase
{
    private AccountRepositoryInterface $accountRepository;
    private EventInterface $eventService;
    private EventMapperInterface $eventMapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
        $this->eventService = new Deposit($this->accountRepository);
        $this->eventMapper = new EventMapper();
    }

    public function testMakeDeposit()
    {
        $this->accountRepository->method('getOne')->willReturn([
            'id' => "100",
            'balance' => 10]);
        $this->accountRepository->method('create')->willReturn(true);
        $this->accountRepository->method('updateBalance')->willReturn(true);

        $eventDTO = $this->eventMapper->map([
            'destination' => "100",
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertEquals(
            (new EventReturnDTO())
                ->setDestination(
                    (new AccountDTO())
                        ->setId("100")
                        ->setBalance(20)),
            $dataReturn
        );
    }

    public function testMakeDepositToNewAccount()
    {
        $this->accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                null,
                [
                    'id' => "100",
                    'balance' => 0
                ],
            );
        $this->accountRepository->method('create')->willReturn(true);
        $this->accountRepository->method('updateBalance')->willReturn(true);

        $eventDTO = $this->eventMapper->map([
            'destination' => "100",
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertEquals(
            (new EventReturnDTO())
                ->setDestination(
                    (new AccountDTO())
                        ->setId("100")
                        ->setBalance(10)),
            $dataReturn
        );
    }
}
