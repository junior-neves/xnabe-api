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
//TODO: retirar o rs
//TODO: mudar variaveis para camel case
    public function create($account_id, $initial_balance) : bool
    {
        $rs = $this->pdo->prepare("INSERT INTO account (id, balance) VALUES (?, ?)");
        $rs = $rs->execute([$account_id, $initial_balance]);
        return $rs;
    }

    public function updateBalance($account_id, $balance) : bool
    {
        $rs = $this->pdo->prepare("UPDATE account SET balance = ? WHERE id = ?");
        $rs = $rs->execute([$balance, $account_id]);
        return $rs;
    }

    public function getOne($account_id) : ?array
    {
        $rs = $this->pdo->prepare("SELECT * FROM account WHERE id = ?");
        $rs->execute([$account_id]);
        $rs = $rs->fetch();
        if (!$rs) {
            return null;
        }
        $rs["balance"] = (int)$rs["balance"];
        return $rs;
    }

    public function getBalance($account_id) : int
    {
        $rs = $this->pdo->prepare("SELECT balance FROM account WHERE id = ?");
        $rs->execute([$account_id]);
        $rs = $rs->fetch();
        return $rs["balance"];
    }

}