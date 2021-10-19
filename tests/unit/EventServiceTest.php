<?php

namespace unit;

use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\EventService;
use PHPUnit\Framework\TestCase;

class EventServiceTest extends TestCase
{
    //TODO: adicionar tipagem
    private AccountRepositoryInterface $accountRepository;

    //TODO: arrumar as pasta do teste igual o app
    protected function setUp(): void
    {
        parent::setUp();
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
    }

    public function testMakeDeposit()
    {

        $this->accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 10
        ]);
        $this->accountRepository->method('create')->willReturn(true);
        $this->accountRepository->method('updateBalance')->willReturn(true);

        //TODO: passar pro setup (DRY)
        $eventService = new EventService($this->accountRepository);
        $dataReturn = $eventService->makeDeposit("100", 10);

        $this->assertEquals(
            [
                'destination' => [
                    'id' => 100,
                    'balance' => 20
                ]
            ],$dataReturn);
    }

    public function testMakeDeposiToNewAccount()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                null,
                [
                    'id' => 100,
                    'balance' => 0
                ],
            );
        $accountRepository->method('create')->willReturn(true);
        $accountRepository->method('updateBalance')->willReturn(true);

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeDeposit("100", 10);

        $this->assertEquals(
            [
                'destination' => [
                    'id' => 100,
                    'balance' => 10
                ]
            ],$dataReturn);
    }

    public function testMakeWithdraw()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 10
        ]);
        $accountRepository->method('updateBalance')->willReturn(true);

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeWithdraw(100, 10);

        $this->assertEquals(
            [
                'origin' => [
                    'id' => 100,
                    'balance' => 0
                ]
            ],$dataReturn);
    }

    public function testMakeWithdrawFromInexistentAccount()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->method('getOne')->willReturn(null);

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeWithdraw(100, 10);

        $this->assertNull($dataReturn);
    }

    public function testMakeWithdrawWithoutEnoughtMoney()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 10
        ]);

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeWithdraw(100, 20);

        $this->assertNull($dataReturn);
    }

    public function testMakeTransfer()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->expects($this->exactly(2))
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
        $accountRepository->method('updateBalance')->willReturn(true);

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeTransfer(100, 200, 10);

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
        $accountRepository = clone $this->accountRepository;
        $accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                null,
                [
                    'id' => 200,
                    'balance' => 0
                ],
            );

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeTransfer(100, 200, 10);

        $this->assertNull($dataReturn);
    }

    public function testMakeTransferToInexistentAccount()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->expects($this->exactly(2))
            ->method('getOne')
            ->willReturnOnConsecutiveCalls(
                [
                    'id' => 100,
                    'balance' => 20
                ],null
            );

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeTransfer(100, 200, 10);

        $this->assertNull($dataReturn);
    }

    public function testMakeTransferWithoutEnoughtMoney()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->expects($this->exactly(2))
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

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->makeTransfer(100, 200, 20);

        $this->assertNull($dataReturn);
    }

    public function testGetAccount()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 15
        ]);

        $eventService = new EventService($accountRepository);
        $dataReturn = $eventService->getAccount(100);

        $this->assertEquals(
            [
                'id' => 100,
                'balance' => 15
            ],$dataReturn);
    }

}
