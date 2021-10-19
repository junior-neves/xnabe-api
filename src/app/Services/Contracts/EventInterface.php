<?php

namespace App\Services\Contracts;

use App\DTO\Event\EventDTO;

interface EventInterface
{

    public function execute(EventDTO $event) : ?array;

}