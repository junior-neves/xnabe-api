<?php

namespace App\DTO\Event;

class EventDTO
{
    private ?string $type = null;
    private ?string $destination = null;
    private ?string $origin = null;
    private ?float $amount = null;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return EventDTO
     */
    public function setType(?string $type): EventDTO
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDestination(): ?string
    {
        return $this->destination;
    }

    /**
     * @param string|null $destination
     * @return EventDTO
     */
    public function setDestination(?string $destination): EventDTO
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    /**
     * @param string|null $origin
     * @return EventDTO
     */
    public function setOrigin(?string $origin): EventDTO
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount
     * @return EventDTO
     */
    public function setAmount(?float $amount): EventDTO
    {
        $this->amount = $amount;
        return $this;
    }


}