<?php

namespace App\Mappers\Contracts;

use App\DTO\Event\EventDTO;

interface EventMapperInterface
{
    public function map(array $dados): EventDTO;
}
