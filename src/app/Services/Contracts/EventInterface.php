<?php

namespace App\Services\Contracts;

use App\DTO\Event\EventDTO;
use App\DTO\Event\EventReturnDTO;

interface EventInterface
{

    public function execute(EventDTO $event): ?EventReturnDTO;
}
