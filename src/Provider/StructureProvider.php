<?php

namespace Structure\Provider;

use Structure\Contract\Structure as StructureContract;
use Structure\Impl\StructureImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class StructureProvider extends ServiceProvider
{
    /** @var Application */
    protected $app;


    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterfac
     */
    public function boot()
    {
        /** @var StructureContract $structure */
        $structure = $this->app->get(StructureContract::class);
        $structure->initModules();
    }

    public function register()
    {
        $this->app->register(\Barryvdh\Cors\ServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->singleton(StructureContract::class, function (Application $app) {
            return new StructureImpl($app);
        });
    }


}