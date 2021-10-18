<?php

namespace Core;

class RepositoryProvider
{

    public static $repositories = [
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