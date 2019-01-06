<?php

namespace Structure\Impl\Module\Initer;

use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Structure\Impl\Module\Initer\Traits\ModuleHelpers;
use Illuminate\Contracts\Foundation\Application;
use \Structure\Contract\Module\Initer\IniterFacade;
use Illuminate\Contracts\Routing\Registrar as Router;

/**
 * Класс инициализирующий папку с роутами модуля
 *
 * Class RoutesIniter
 * @package Structure\Impl\Module\Initer
 */
class RoutesIniter implements IniterFacade
{
    use ModuleHelpers;

    /**
     * @var Application $application
     */
    protected $application;
    /**
     * @var Router
     */
    protected $router;

    /**
     * RoutesIniter constructor.
     * @param Application $application
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->router = $application->get(Router::class);
    }

    /**
     * @param array $config
     * @return mixed|void
     * @throws \Structure\Impl\Module\Exception\ModuleNotCreatedException
     */
    public function init(array $config)
    {
        if (!empty($config["routes"])) {
            if (!is_array($config["routes"])) {
                throw new ModuleNotCreatedException("module routes property is not array");
            }
            $moduleNamespace = $this->getNamespace($config);
            foreach ($config["routes"] as $routeFile) {
                $absolutePath = $this->getAbsolutePath($config, $routeFile);
                $this->router->group(["namespace" => "$moduleNamespace\\Controller"], function (Router $router) use ($absolutePath) {
                    require $absolutePath;
                });
            }
        }
    }
}