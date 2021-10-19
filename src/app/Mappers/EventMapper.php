<?php

namespace App\Mappers;

use App\DTO\Event\EventDTO;
use App\Mappers\Contracts\EventMapperInterface;

class EventMapper implements EventMapperInterface
{

    public function map(array $data): EventDTO
    {
        return (new EventDTO())
            ->setType($data["type"] ?? null)
            ->setAmount($data["amount"] ?? null)
            ->setOrigin($data["origin"] ?? null)
            ->setDestination($data["destination"] ?? null);
    }
}
