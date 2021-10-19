<?php

namespace App\Repositories;

use App\Repositories\Contracts\ResetRepositoryInterface;
use Core\Database;

class ResetRepositoryPDO implements ResetRepositoryInterface
{
    private Database $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function reset(): bool
    {
        $result = $this->pdo->prepare("DELETE FROM account WHERE 1");
        return $result->execute();
    }

    public function create(): bool
    {
        $result = $this->pdo->prepare("INSERT INTO account (id, balance) VALUES ('300', 0)");
        return $result->execute();
    }
}
