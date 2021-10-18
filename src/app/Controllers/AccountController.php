<?php

namespace App\Controllers;


use App\Services\Contracts\AccountServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController
{

    protected JsonResponse $response;
    private AccountServiceInterface $accountService;

    public function __construct(AccountServiceInterface $accountService)
    {
        $this->response = new JsonResponse();
        $this->accountService = $accountService;
    }

    public function getBalance(Request $request) : JsonResponse
    {
        $account_id = $request->query->get("account_id");
        $balance = $this->accountService->getBalance($account_id);

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