<?php

namespace App\Controllers;


use App\DTO\Event\EventDTO;
use App\Exceptions\Account\AccountNotFoundException;
use App\Mappers\Contracts\EventMapperInterface;
use App\Services\Factories\EventFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController
{

    protected JsonResponse $response;
    private EventFactory $eventFactory;
    private EventMapperInterface $eventMapper;

    public function __construct(EventFactory $eventFactory, EventMapperInterface $eventMapper)
    {
        $this->response = new JsonResponse();
        $this->eventFactory = $eventFactory;
        $this->eventMapper = $eventMapper;
    }

    public function handler(Request $request) : JsonResponse
    {
        if (!$request->getContent()) {
            $this->response->setData(["Error" => "Empty json"]);
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        $request = $request->toArray();

        //TODO: criar exceptiosn da account
        //TODO: EventResponse no DTO / toArray

        try {
            $eventDTO = $this->eventMapper->map($request);

            $event = $this->eventFactory->factory($request['type']);
            $data = $event->execute($eventDTO);

            $this->response->setData($data);
            return $this->response->setStatusCode(Response::HTTP_CREATED);
        } catch (AccountNotFoundException $error ) {
            $this->response->setData([$error->getMessage()]);
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

    }

}