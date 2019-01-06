<?php

namespace Structure\Impl;

use Structure\Impl\Module\Initer\PolicyIniter;
use Structure\Contract\Module\Module;
use \Structure\Contract\Structure;
use Structure\Impl\Module\Defer\DeferObservable;
use Structure\Impl\Module\Initer\ConfigsIniter;
use Structure\Impl\Module\Initer\LanguagesIniter;
use Structure\Impl\Module\Initer\MiddlewaresIniter;
use Structure\Impl\Module\Initer\ProvidersIniter;
use Structure\Impl\Module\Initer\RepositoriesIniter;
use Structure\Impl\Module\Initer\RoutesIniter;
use Structure\Impl\Module\Initer\ViewsIniter;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;

/**
 * Class StructureImpl
 * @package Structure\Impl
 */
class StructureImpl implements Structure
{
    /** @var Application */
    protected $application;

    /**
     * Structure constructor.
     * @param Application $application
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }


    /**
     * @throws ModuleNotCreatedException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function initModules()
    {
        $modules = $this->getModuleList();
        $app = $this->application;
        foreach ($modules as $moduleClassName) {
            /**
             * Создаем новый модуь
             * @var Module $moduleObj
             */
            $moduleObj = new $moduleClassName(
                new RoutesIniter($app),
                new LanguagesIniter($app),
                new MiddlewaresIniter($app),
                new ProvidersIniter($app),
                new ConfigsIniter($app),
                new ViewsIniter($app),
                new RepositoriesIniter($app),
                new PolicyIniter($app)
            );

            if (!$moduleObj instanceof Module) {
                throw new ModuleNotCreatedException();
            }
            $moduleObj->init();
        }
        $this->runDeferAction();
    }

    /**
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getModuleList(): array
    {
        $config = $this->application->get(Repository::class);
        $modulesArray = $config->get("module.list", []);
        $modulesArray = (is_array($modulesArray)) ? $modulesArray : [];
        return $modulesArray;
    }

    /**
     * Выполнить отложеные действия
     */
    protected function runDeferAction()
    {
        DeferObservable::runDeferActions();
    }
}
