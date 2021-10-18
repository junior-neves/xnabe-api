<?php

namespace Core;

class ServiceProvider
{

    public static $services = [
        "App\Controllers\AccountController" => [
            "App\Services\AccountService"
        ],
        "App\Controllers\EventController" => [
            "App\Services\EventService"
        ],
        "App\Controllers\ResetController" => [
            "App\Services\ResetService"
        ],
    ];

}