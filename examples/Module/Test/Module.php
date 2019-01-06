<?php

namespace App\Module\Test;

use App\Module\Test\Repository\Impl\TestRepositoryImpl;
use App\Module\Test\Repository\TestRepository;
use App\Module\Test\Middleware\TestMiddleware;
use App\Module\Test\Provider\TestReposiotyProvider;
use App\Module\Test\Provider\TestRepositoryProvider;
use App\Module\Test\Provider\TestServiceProvider;
use Structure\Impl\Module\BaseModule;

class Module extends BaseModule
{
    protected $config = [
        "name" => "test",
        "languages" => "resource/lang",
        "providers" => [
            TestServiceProvider::class
        ],
        "middlewares" => [
            "groups" => [
                "testGroup" => [
                    TestMiddleware::class
                ]
            ],
            "aliases" => [
                "test" => TestMiddleware::class
            ]
        ],
        "views" => "resource/view",
        "routes" => [
            "route/api.php"
        ],
        "repositories" => [
            TestRepository::class => TestRepositoryImpl::class
        ],
    ];
}