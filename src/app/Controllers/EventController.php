<?php

namespace App\Controllers;


use App\DTO\Event\EventDTO;
use App\Exceptions\Account\AccountNotFoundException;
use App\Services\Factories\EventFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController
{

    protected JsonResponse $response;
    private EventFactory $eventFactory;
    //
    public function __construct(EventFactory $eventFactory)
    {
        $this->response = new JsonResponse();
        $this->eventFactory = $eventFactory;
    }

    public function handler(Request $request) : JsonResponse
    {
        if (!$request->getContent()) {
            $this->response->setData(["Error" => "Empty json"]);
            return $this->response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        $request = $request->toArray();

        //TODO: criar exceptiosn da account
        //TODO: criar um mapper, recebe o request e volta o eventDTO
        //TODO: EventResponse no DTO / toArray
        //tira a responsabilidade de fabricar do controller

        try {
            $event = $this->eventFactory->factory($request['type']);
            $eventDTO = (new EventDTO())
                ->setType($request["type"] ?? null)
                ->setAmount($request["amount"] ?? null)
                ->setOrigin($request["origin"] ?? null)
                ->setDestination($request["destination"] ?? null);
            $data = $event->execute($eventDTO);

            $this->response->setData($data);
            return $this->response->setStatusCode(Response::HTTP_CREATED);
        } catch (AccountNotFoundException $error ) {
            $this->response->setData([$error->getMessage()]);
            return $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        }

    }

}