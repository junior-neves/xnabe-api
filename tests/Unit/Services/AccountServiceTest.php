<?php

namespace Unit\Services;

use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Services\AccountService;
use PHPUnit\Framework\TestCase;

class AccountServiceTest extends TestCase
{
    private $accountRepository;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
    }

    public function testGetAccount()
    {
        $accountRepository = clone $this->accountRepository;
        $accountRepository->method('getOne')->willReturn([
            'id' => 100,
            'balance' => 15
        ]);

        $accountService = new AccountService($accountRepository);
        $dataReturn = $accountService->getAccount(100);

        $this->assertEquals(
            [
                'id' => 100,
                'balance' => 15
            ]
            ,$dataReturn);
    }

    public function testGetBalance()
    {
        $accountRepository = clone $this->accountRepository;

        $accountRepository->method('getOne')->willReturn(
            [
                'id' => 100,
                'balance' => 15
            ]
        );
        $accountRepository->method('getBalance')->willReturn(15);

        $accountService = new AccountService($accountRepository);
        $dataReturn = $accountService->getBalance(100);

        $this->assertEquals(15,$dataReturn);
    }

}
