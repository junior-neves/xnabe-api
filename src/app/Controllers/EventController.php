<?php

namespace App\Controllers;


use App\Services\Contracts\EventServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController
{

    protected JsonResponse $response;
    private EventServiceInterface $eventService;

    public function __construct(EventServiceInterface $eventService)
    {
        $this->response = new JsonResponse();
        $this->eventService = $eventService;
    }

    public function handler(Request $request) : JsonResponse
    {

        if (!$request->getContent()) {
            $this->response->setData(["Error" => "Empty json"]);
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        $request = $request->toArray();

        if ($request['type'] == "deposit") {
            $data = $this->eventService->makeDeposit($request['destination'], $request['amount']);
            $this->response->setData($data);
            return $this->response->setStatusCode(Response::HTTP_CREATED);
        }

        if ($request['type'] == "withdraw") {
            $data = $this->eventService->makeWithdraw($request['origin'], $request['amount']);
            if (is_null($data)) {
                $this->response->setData(0);
                return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            }

            $this->response->setData($data);
            return $this->response->setStatusCode(Response::HTTP_CREATED);
        }

        if ($request['type'] == "transfer") {
            $data = $this->eventService->makeTransfer($request['origin'], $request['destination'], $request['amount']);
            if (is_null($data)) {
                $this->response->setData(0);
                return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
            }

            $this->response->setData($data);
            return $this->response->setStatusCode(Response::HTTP_CREATED);
        }

        return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
    }

}