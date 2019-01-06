<?php

namespace Structure\Impl\Module\Initer;

use Structure\Contract\Module\Initer\IniterFacade;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Router;

/**
 * Класс инициализации middleware
 *
 * Class MiddlewaresIniter
 * @package Structure\Impl\Module\Initer
 */
class MiddlewaresIniter implements IniterFacade
{
    /**
     * @var Application $application
     */
    protected $application;
    /**
     * @var Router
     */
    protected $router;

    /**
     * MiddlewaresIniter constructor.
     * @param Application $application
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->router = $application->get(Registrar::class);
    }


    /**
     * @param array $config
     * @throws ModuleNotCreatedException инициализация middleware
     */
    public function init(array $config)
    {
        if (!empty($config["middlewares"]) && !is_array($config["middlewares"])) {
            throw new ModuleNotCreatedException("middlewares option is not array");
        }
        if (!empty($config["middlewares"]["groups"])) {
            if (!is_array($config["middlewares"]["groups"])) {
                throw new ModuleNotCreatedException("middlewares groups option is not array");
            }
            $this->initMiddlewaresGroup($config["middlewares"]["groups"]);
        }
        if (!empty($config["middlewares"]["aliases"])) {
            if (!is_array($config["middlewares"]["aliases"])) {
                throw new ModuleNotCreatedException("middlewares aliases option is not array");
            }
            $this->initMiddlewareAliases($config["middlewares"]["aliases"]);
        }
    }

    /**
     * @param array $middlewaresGroup
     * @throws ModuleNotCreatedException инициализацтя группы middleware
     */
    protected function initMiddlewaresGroup(array $middlewaresGroup)
    {
        foreach ($middlewaresGroup as $groupName => $middlewares) {
            if (!is_array($middlewares)) {
                throw new ModuleNotCreatedException("middlewares from group is not array");
            }
            $this->router->middlewareGroup($groupName, $middlewares);
        }
    }

    /**
     * инициализацтя алиасов middleawre
     *
     * @param array $middlewares
     * @throws ModuleNotCreatedException
     */
    protected function initMiddlewareAliases(array $middlewares)
    {
        foreach ($middlewares as $alias => $class) {
            if (!is_string($class)) {
                throw new ModuleNotCreatedException("middlewares class not string");
            }
            $this->router->aliasMiddleware($alias, $class);
        }
    }
}