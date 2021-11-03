<?php

namespace App\DTO\Event;

use App\DTO\Account\AccountDTO;

class EventReturnDTO
{
    private ?AccountDTO $origin = null;
    private ?AccountDTO $destination = null;

    /**
     * @return AccountDTO|null
     */
    public function getOrigin(): ?AccountDTO
    {
        return $this->origin;
    }

    /**
     * @param AccountDTO|null $origin
     * @return EventReturnDTO
     */
    public function setOrigin(?AccountDTO $origin): EventReturnDTO
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return AccountDTO|null
     */
    public function getDestination(): ?AccountDTO
    {
        return $this->destination;
    }

    /**
     * @param AccountDTO|null $destination
     * @return EventReturnDTO
     */
    public function setDestination(?AccountDTO $destination): EventReturnDTO
    {
        $this->destination = $destination;
        return $this;
    }

    public function toArray(): array
    {
        $return = [];

        if ($this->origin) {
            $return["origin"] = [
                "id" => $this->origin->getId(),
                "balance" => $this->origin->getBalance(),
            ];
        }

        if ($this->destination) {
            $return["destination"] = [
                "id" => $this->destination->getId(),
                "balance" => $this->destination->getBalance(),
            ];
        }

        return $return;
    }


}