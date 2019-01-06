<?php

namespace App\Module\Test\Provider;

use App\Module\Test\Service\Impl\TestServiceImpl;
use App\Module\Test\Service\TestService;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(TestService::class, function ($app) {
            return new TestServiceImpl();
        });
    }


}