<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController
{
    protected JsonResponse $response;

    public function __construct()
    {
        $this->response = new JsonResponse();
    }

}
