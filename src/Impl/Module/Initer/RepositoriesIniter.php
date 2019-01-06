<?php

namespace Structure\Impl\Module\Initer;

use Structure\Contract\Repository;
use Structure\Contract\Module\Initer\IniterFacade;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Router;

/**
 * Класс инициализации репоизиториев
 *
 * Class RepositoriesIniter
 * @package Structure\Impl\Module\Initer
 */
class RepositoriesIniter implements IniterFacade
{
    /**
     * @var Application $application
     */
    protected $application;


    /**
     * RepositoriesIniter constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }


    /**
     * @param array $config
     * @throws ModuleNotCreatedException инициализация middleware
     */
    public function init(array $config)
    {
        if (!empty($config["repositories"])) {
            if (!is_array($config["repositories"])) {
                throw new ModuleNotCreatedException("repositories property is not array");
            }
            foreach ($config["repositories"] as $repositoryContract => $repositoryClass) {
                if (!is_string($repositoryContract) || !is_string($repositoryClass)) {
                    throw new ModuleNotCreatedException("repositories key or value not string");
                }
                $this->application->singleton($repositoryContract, function (Application $app) use ($repositoryClass) {
                    /** @var Repository $repository */
                    $repository = new $repositoryClass();
                    if (!$repository instanceof Repository) {
                        throw new ModuleNotCreatedException("repositories in not implements repository contract");
                    }
                    $modelClassName = $repository->getModelClassName();
                    $repository->setModel(new $modelClassName());
                    return $repository;
                });
            }
        }
    }

}