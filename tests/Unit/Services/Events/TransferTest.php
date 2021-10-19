<?php

namespace Unit\Services\Events;

use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Account\InsufficientBalanceException;
use App\Mappers\Contracts\EventMapperInterface;
use App\Mappers\EventMapper;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;
use App\Services\Events\Deposit;
use App\Services\Events\Transfer;
use PHPUnit\Framework\TestCase;

class TransferTest extends TestCase
{
    private AccountRepositoryInterface $accountRepository;
    private EventInterface $eventService;
    private EventMapperInterface $eventMapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
        $this->eventService = new Transfer($this->accountRepository);
        $this->eventMapper = new EventMapper();
    }

    public function testMakeTransfer()
    {
        $this->accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 100,
                    'balance' => 20
                ],
                [
                    'id' => 200,
                    'balance' => 0
                ],
            );
        $this->accountRepository->method('updateBalance')->willReturn(true);

        $eventDTO = $this->eventMapper->map([
            'origin' => "100",
            'destination' => "200",
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertEquals(
            [
                'origin' => [
                    'id' => 100,
                    'balance' => 10
                ],
                'destination' => [
                    'id' => 200,
                    'balance' => 10
                ]
            ],$dataReturn);
    }

    public function testMakeTransferFromInexistentAccount()
    {
        $this->accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                null,
                [
                    'id' => 200,
                    'balance' => 0
                ],
            );
        $this->expectException(AccountNotFoundException::class);

        $eventDTO = $this->eventMapper->map([
            'origin' => "100",
            'destination' => "200",
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertNull($dataReturn);
    }

    public function testMakeTransferToInexistentAccount()
    {
        $this->accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 100,
                    'balance' => 20
                ],null
            );
        $this->expectException(AccountNotFoundException::class);

        $eventDTO = $this->eventMapper->map([
            'origin' => "100",
            'destination' => "200",
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertNull($dataReturn);
    }

    public function testMakeTransferWithoutEnoughtMoney()
    {
        $this->accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 100,
                    'balance' => 10
                ],
                [
                    'id' => 200,
                    'balance' => 0
                ],
            );
        $this->expectException(InsufficientBalanceException::class);

        $eventDTO = $this->eventMapper->map([
            'origin' => "100",
            'destination' => "200",
            'amount' => 20]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertNull($dataReturn);
    }

}
