<?php

namespace Structure\Impl\Module\Initer;

use Structure\Impl\Module\Initer\Traits\ModuleHelpers;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Structure\Contract\Module\Initer\IniterFacade;

/**
 * Класс инициализирующий конфиги модуля
 * в общий клас конфигов
 *
 * Class ConfigsIniter
 * @package Structure\Impl\Module\Initer
 */
class ConfigsIniter implements IniterFacade
{
    use ModuleHelpers;

    /**
     * @var Application $application
     */
    protected $application;
    /**
     * @var Repository
     */
    protected $config;

    /**
     * ConfigsIniter constructor.
     * @param Application $application
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->config = $application->get(Repository::class);
    }


    /**
     * Инициализировать компоненту модуля
     *
     * @param array $config
     * @throws \Structure\Impl\Module\Exception\ModuleNotCreatedException
     */
    public function init(array $config)
    {
        $this->checkModuleNameFromConfig($config);
        $this->config->set($config["name"], $config);
    }
}