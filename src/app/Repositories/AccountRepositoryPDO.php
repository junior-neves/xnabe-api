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

    public function create($account_id, $initial_balance)
    {
        $rs = $this->pdo->prepare("INSERT INTO account (id, balance) VALUES (?, ?)");
        $rs = $rs->execute([$account_id, $initial_balance]);
        return $rs;
    }

    public function updateBalance($account_id, $balance)
    {
        $rs = $this->pdo->prepare("UPDATE account SET balance = ? WHERE id = ?");
        $rs = $rs->execute([$balance, $account_id]);
        return $rs;
    }

    public function getOne($account_id)
    {
        $rs = $this->pdo->prepare("SELECT * FROM account WHERE id = ?");
        $rs->execute([$account_id]);
        return $rs->fetch();
    }

    public function getBalance($account_id) : int
    {
        $rs = $this->pdo->prepare("SELECT balance FROM account WHERE id = ?");
        $rs->execute([$account_id]);
        $rs = $rs->fetch();
        return $rs["balance"];
    }

}