<?php

namespace Unit\Controllers;

use App\Controllers\EventController;
use App\DTO\Event\EventDTO;
use App\Exceptions\Account\AccountNotFoundException;
use App\Mappers\Contracts\EventMapperInterface;
use App\Services\Contracts\EventInterface;
use App\Services\Factories\EventFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventControllerTest extends TestCase
{
    private EventFactory $eventFactory;
    private EventMapperInterface $eventMapper;
    private EventController $eventController;
    private Request $request;
    private JsonResponse $response;
    private EventInterface $event;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventFactory = $this->createMock(EventFactory::class);
        $this->eventMapper = $this->createMock(EventMapperInterface::class);
        $this->event = $this->createMock(EventInterface::class);
        $this->eventController = new EventController($this->eventFactory, $this->eventMapper);
        $this->request = new Request();
        $this->response = new JsonResponse();

        $this->request->initialize([],[
            'type' => 'deposit',
            'destination' => 100,
            'amount' => 10
        ],[],[],[],[],'{"type":"deposit", "destination":"100", "amount":10}');
    }

    public function testHandler()
    {
        $this->eventMapper->method('map')->willReturn(new EventDTO());
        $this->eventFactory->method('factory')->willReturn($this->event);
        $this->event->method('execute')->willReturn([
            'destination' => [
                'id' => 100,
                'balance' => 20
            ]
        ]);

        $this->response
            ->setData(
                [
                    'destination' => [
                        'id' => 100,
                        'balance' => 20
                    ]
                ])
            ->setStatusCode(Response::HTTP_CREATED);

        $dataReturn = $this->eventController->handler($this->request);

        $this->assertEquals($this->response,$dataReturn);
    }

    public function testHandlerWithError() {
        $this->eventMapper->method('map')->willReturn(new EventDTO());
        $this->eventFactory->method('factory')
            ->will($this->throwException(new AccountNotFoundException()));

        $this->response
            ->setData(0)
            ->setStatusCode(Response::HTTP_NOT_FOUND);

        $dataReturn = $this->eventController->handler($this->request);

        $this->assertEquals($this->response,$dataReturn);
    }

}
