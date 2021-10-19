<?php

namespace App\Controllers;

use App\Services\ResetService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ResetController
{
    protected JsonResponse $response;
    private ResetService $resetService;

    public function __construct(ResetService $resetService)
    {
        $this->response = new JsonResponse();
        $this->resetService = $resetService;
    }

    public function reset(Request $request): JsonResponse
    {
        $this->resetService->reset();
        $this->response->setContent("OK");
        $this->response->setStatusCode(200);

        return $this->response;
    }
}
