<?php

namespace App\Controllers;

use App\Services\Contracts\AccountServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends BaseController
{
    private AccountServiceInterface $accountService;

    public function __construct(AccountServiceInterface $accountService)
    {
        parent::__construct();
        $this->accountService = $accountService;
    }

    public function getBalance(Request $request): JsonResponse
    {
        $accountId = $request->query->get("account_id");
        $balance = $this->accountService->getBalance($accountId);

        if (is_null($balance)) {
            $this->response->setData(0);
            $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            return $this->response;
        }

        $this->response->setData($balance);
        $this->response->setStatusCode(Response::HTTP_OK);
        return $this->response;
    }
}
