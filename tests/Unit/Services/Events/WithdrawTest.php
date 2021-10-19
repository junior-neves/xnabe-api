<?php

namespace Unit\Services\Events;

use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Account\InsufficientBalanceException;
use App\Mappers\Contracts\EventMapperInterface;
use App\Mappers\EventMapper;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\Contracts\EventInterface;
use App\Services\Events\Withdraw;
use PHPUnit\Framework\TestCase;

class WithdrawTest extends TestCase
{
    private AccountRepositoryInterface $accountRepository;
    private EventInterface $eventService;
    private EventMapperInterface $eventMapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
        $this->eventService = new Withdraw($this->accountRepository);
        $this->eventMapper = new EventMapper();
    }

    public function testMakeWithdraw()
    {
        $this->accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 10
        ]);
        $this->accountRepository->method('updateBalance')->willReturn(true);

        $eventDTO = $this->eventMapper->map([
            'origin' => 100,
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

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
        $this->accountRepository->method('getOne')->willReturn(null);
        $this->expectException(AccountNotFoundException::class);

        $eventDTO = $this->eventMapper->map([
            'origin' => 100,
            'amount' => 10]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertNull($dataReturn);
    }

    public function testMakeWithdrawWithoutEnoughtMoney()
    {
        $this->accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 10
        ]);
        $this->expectException(InsufficientBalanceException::class);

        $eventDTO = $this->eventMapper->map([
            'origin' => 100,
            'amount' => 20]);
        $dataReturn = $this->eventService->execute($eventDTO);

        $this->assertNull($dataReturn);
    }

}
