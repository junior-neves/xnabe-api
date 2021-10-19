<?php

namespace Core;

class ServiceProvider
{

    public static array $services = [
        "App\Controllers\AccountController" => [
            "App\Services\AccountService"
        ],
        "App\Controllers\EventController" => [
            "App\Services\Factories\EventFactory",
            "App\Mappers\EventMapper"
        ],
        "App\Controllers\ResetController" => [
            "App\Services\ResetService"
        ],
    ];
}
