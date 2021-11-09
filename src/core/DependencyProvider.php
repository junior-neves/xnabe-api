<?php

namespace Core;

class DependencyProvider
{

    public static array $dependencies = [
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

    public static function getDependencies($className): ?object
    {
        if ( !isset(self::$dependencies["{$className}"]) ) {
            return (new $className());
        }

        $dependenciesList = [];

        foreach (self::$dependencies["{$className}"] as $dependencyClass)
        {
            $dependency = self::getDependencies($dependencyClass);
            $dependenciesList[] = $dependency;
        }

        return (new $className(...$dependenciesList));
    }
}
