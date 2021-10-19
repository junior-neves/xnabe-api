<?php

namespace App\Repositories;

use App\Repositories\Contracts\AccountRepositoryInterface;
use Core\Database;

class AccountRepositoryPDO implements AccountRepositoryInterface
{
    private Database $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function create($accountId, $initialBalance): bool
    {
        $result = $this->pdo->prepare("INSERT INTO account (id, balance) VALUES (?, ?)");
        return $result->execute([$accountId, $initialBalance]);
    }

    public function updateBalance($accountId, $balance): bool
    {
        $result = $this->pdo->prepare("UPDATE account SET balance = ? WHERE id = ?");
        return $result->execute([$balance, $accountId]);
    }

    public function getOne($accountId): ?array
    {
        $result = $this->pdo->prepare("SELECT * FROM account WHERE id = ?");
        $result->execute([$accountId]);
        $result = $result->fetch();
        if (!$result) {
            return null;
        }
        $result["balance"] = (int)$result["balance"];
        return $result;
    }

    public function getBalance($accountId): int
    {
        $result = $this->pdo->prepare("SELECT balance FROM account WHERE id = ?");
        $result->execute([$accountId]);
        $result = $result->fetch();
        return $result["balance"];
    }
}
