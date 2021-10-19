<?php

namespace Unit\Controllers;

use App\Controllers\AccountController;
use App\Services\Contracts\AccountServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountControllerTest extends TestCase
{
    private AccountServiceInterface $accountService;
    private AccountController $accountController;
    private Request $request;
    private JsonResponse $response;


    protected function setUp(): void
    {
        parent::setUp();
        $this->accountService = $this->createMock(AccountServiceInterface::class);
        $this->accountController = new AccountController($this->accountService);
        $this->request = new Request();
        $this->response = new JsonResponse();
    }

    public function testGetBalance()
    {
        $this->accountService->method('getBalance')->willReturn(10);
        $this->request->initialize(["account_id" => 100]);


        $this->response->setData(10)->setStatusCode(Response::HTTP_OK);

        $dataReturn = $this->accountController->getBalance($this->request);

        $this->assertEquals($this->response,$dataReturn);
    }

}
