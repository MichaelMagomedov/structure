<?php

namespace Structure\Impl\Module;

use Structure\Contract\Module\Initer\IniterFacade;
use Structure\Contract\Module\Module;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Structure\Impl\Module\Initer\ConfigsIniter;
use Structure\Impl\Module\Initer\LanguagesIniter;
use Structure\Impl\Module\Initer\MiddlewaresIniter;
use Structure\Impl\Module\Initer\PolicyIniter;
use Structure\Impl\Module\Initer\ProvidersIniter;
use Structure\Impl\Module\Initer\RepositoriesIniter;
use Structure\Impl\Module\Initer\RoutesIniter;
use Structure\Impl\Module\Initer\ViewsIniter;


/**
 * Базовый клас модуля
 *
 * Class BaseModule
 * @package Structure\Impl\Module
 */
class BaseModule implements Module
{
    /**
     * @var RoutesIniter
     */
    private $routesIniter;
    /**
     * @var LanguagesIniter
     */
    protected $languagesIniter;
    /**
     * @var MiddlewaresIniter
     */
    protected $middlwaresIniter;
    /**
     * @var ProvidersIniter
     */
    protected $providersIniter;
    /**
     * @var ConfigsIniter
     */
    protected $configsIniter;
    /**
     * @var ViewsIniter
     */
    protected $viewsIniter;

    /**
     * @var PolicyIniter
     */
    protected $policiesIniter;

    /**
     * @var array
     */
    protected $config;
    /**
     * @var RepositoriesIniter
     */
    protected $repositoriesIniter;

    public function __construct(
        IniterFacade $routesIniter,
        IniterFacade $languagesIniter,
        IniterFacade $middlwaresIniter,
        IniterFacade $providersIniter,
        IniterFacade $configsIniter,
        IniterFacade $viewsIniter,
        IniterFacade $repositoirsIniter,
        IniterFacade $policiesIniter
    )
    {
        $this->routesIniter = $routesIniter;
        $this->languagesIniter = $languagesIniter;
        $this->middlwaresIniter = $middlwaresIniter;
        $this->providersIniter = $providersIniter;
        $this->configsIniter = $configsIniter;
        $this->viewsIniter = $viewsIniter;
        $this->repositoriesIniter = $repositoirsIniter;
        $this->policiesIniter = $policiesIniter;
    }

    /**
     * @return mixed|void
     * @throws ModuleNotCreatedException
     */
    public function init()
    {
        if (empty($this->config)) {
            throw new ModuleNotCreatedException("module config empty");
        }
        $this->initLanguages();
        $this->initRepositories();
        $this->initProviders();
        $this->initMiddlewares();
        $this->initViews();
        $this->initPolicies();
        $this->initRoutes();
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initConfigs()
    {
        $this->configsIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initLanguages()
    {
        $this->languagesIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initProviders()
    {
        $this->providersIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initMiddlewares()
    {
        $this->middlwaresIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initViews()
    {
        $this->viewsIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initRoutes()
    {
        $this->routesIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initPolicies(){
        $this->policiesIniter->init($this->config);
    }

    /**
     * @throws ModuleNotCreatedException
     */
    protected function initRepositories()
    {
        $this->repositoriesIniter->init($this->config);
    }

}