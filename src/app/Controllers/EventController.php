<?php

namespace App\Controllers;

use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Account\InsufficientBalanceException;
use App\Exceptions\Event\EventFactoryNotAllowedException;
use App\Mappers\Contracts\EventMapperInterface;
use App\Services\Factories\EventFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends BaseController
{
    private EventFactory $eventFactory;
    private EventMapperInterface $eventMapper;

    public function __construct(EventFactory $eventFactory, EventMapperInterface $eventMapper)
    {
        parent::__construct();
        $this->eventFactory = $eventFactory;
        $this->eventMapper = $eventMapper;
    }

    public function handler(Request $request): JsonResponse
    {
        if (!$request->getContent()) {
            $this->response->setData(["Error" => "Empty json"]);
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        $request = $request->toArray();

        try {
            $eventDTO = $this->eventMapper->map($request);

            $event = $this->eventFactory->factory($request['type']);
            $eventReturn = $event->execute($eventDTO);

            $this->response->setData($eventReturn->toArray());
            return $this->response->setStatusCode(Response::HTTP_CREATED);
        } catch (
            AccountNotFoundException |
            InsufficientBalanceException |
            EventFactoryNotAllowedException
        ) {
            $this->response->setData(0);
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
    }
}
