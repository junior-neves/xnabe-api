<?php

namespace Unit\Controllers;

use App\Controllers\AccountController;
use App\Controllers\ResetController;
use App\Services\Contracts\AccountServiceInterface;
use App\Services\ResetService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResetControllerTest extends TestCase
{
    private ResetController $resetController;
    private Request $request;
    private JsonResponse $response;


    protected function setUp(): void
    {
        parent::setUp();
        $resetService = $this->createMock(ResetService::class);
        $this->resetController = new ResetController($resetService);
        $this->request = new Request();
        $this->response = new JsonResponse();
    }

    public function testReset()
    {
        $this->response->setContent("OK")->setStatusCode(Response::HTTP_OK);

        $dataReturn = $this->resetController->reset($this->request);

        $this->assertEquals($this->response,$dataReturn);
    }

}
