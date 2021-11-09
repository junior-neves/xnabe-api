<?php

namespace App\DTO\Account;

class AccountDTO
{
    private ?string $id = null;
    private ?float $balance = null;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return AccountDTO
     */
    public function setId(?string $id): AccountDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getBalance(): ?float
    {
        return $this->balance;
    }

    /**
     * @param float|null $balance
     * @return AccountDTO
     */
    public function setBalance(?float $balance): AccountDTO
    {
        $this->balance = $balance;
        return $this;
    }
}