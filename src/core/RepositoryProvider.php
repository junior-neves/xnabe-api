<?php

namespace Core;

class RepositoryProvider
{

    public static array $repositories = [
        "App\Services\AccountService" => [
            "App\Repositories\AccountRepositoryPDO"
        ],
        "App\Services\EventService" => [
            "App\Repositories\AccountRepositoryPDO"
        ],
        "App\Services\ResetService" => [
            "App\Repositories\ResetRepositoryPDO"
        ]
    ];
}
