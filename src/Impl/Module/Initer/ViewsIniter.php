<?php

namespace Structure\Impl\Module\Initer;

use Structure\Contract\Module\Initer\IniterFacade;
use Structure\Contract\Module\Defer\DeferObserver;
use Structure\Impl\Module\Defer\DeferObservable;
use Structure\Impl\Module\Initer\Traits\ModuleHelpers;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Illuminate\View\ViewServiceProvider;

/**
 * Класс инициализации папок с представлениями
 *
 * Class ViewIniter
 * @package Structure\Impl\Module\Initer
 */
class ViewsIniter implements IniterFacade, DeferObserver
{
    use ModuleHelpers;

    /**
     * @var Application $application
     */
    protected $application;
    /**
     * @var string
     */
    protected $deferKey = "views";
    /**
     * @var Repository $config
     */
    protected $config;
    /**
     * Общее локальное хранилише путей
     */
    protected static $paths = [];

    /**
     * ViewsIniter constructor.
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
     * @param array $config
     * @return mixed|void
     * @throws ModuleNotCreatedException
     */
    public function init(array $config)
    {
        $this->checkModuleNameFromConfig($config);

        if (!empty($config["views"])) {

            if (!is_string($config["views"])) {
                throw new ModuleNotCreatedException("views folder not string");
            }
            $absolutePath = $this->getAbsolutePath($config, $config["views"]);
            array_push(static::$paths, $absolutePath);

            /* говорим что у данного инитора есть отложеные действия */
            DeferObservable::setDeferIniter($this->deferKey, $this);
        }
    }

    /**
     * после того как все папки указаны заного иницилизируем views
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function runDeferAction()
    {
        /** @var array $viewConfig */
        $viewConfig = $this->config->get("view");
        if (empty($viewConfig["paths"]) || !is_array($viewConfig["paths"])) {
            $viewConfig["paths"] = [];
        };
        $viewConfig["paths"] = array_merge($viewConfig["paths"], static::$paths);
        $this->config->set("view", $viewConfig);
        (new ViewServiceProvider($this->application))->register();
    }
}