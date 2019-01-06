<?php

namespace Structure\Impl\Module\Initer;

use Structure\Contract\Module\Initer\IniterFacade;
use Structure\Contract\Module\Defer\DeferObserver;
use Structure\Impl\Module\Defer\DeferObservable;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Structure\Util\MultipleFileLoader;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Translation\Translator;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Structure\Impl\Module\Initer\Traits\ModuleHelpers;

/**
 * Клас инициализирующий папку с языковыми константами
 *
 * Class LanguagesIniter
 * @package Structure\Impl\Module\Initer
 */
class LanguagesIniter implements IniterFacade, DeferObserver
{
    use ModuleHelpers;

    /**
     * @var Application $application
     */
    protected $application;
    /**
     * @var string
     */
    protected $deferKey = "languages";
    /**
     * @var Repository
     */
    protected $config;
    /**
     * Общее локальное хранилише путей
     */
    protected static $paths = [];

    /**
     * LanguagesIniter constructor.
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
     * @throws ModuleNotCreatedException
     */
    public function init(array $config)
    {
        if (!empty($config["languages"])) {

            if (!is_string($config["languages"])) {
                throw new ModuleNotCreatedException("language folders is not string");
            }
            $path = trim($config["languages"], "/");
            $path = $this->getAbsolutePath($config, $path);
            $moduleName = mb_strtolower($this->getModuleName($config));
            static::$paths[$moduleName] = $path;

            /**
             * устанавливаем то что данный инитер был последним инитаром языковых констант*/
            DeferObservable::setDeferIniter($this->deferKey, $this);

        }
    }

    /**
     * заного  иницилазируем транслятор со всеми папками
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function runDeferAction()
    {

        $langConfig = $this->config->get("lang");
        if (empty($langConfig["paths"]) || (!empty($langConfig["paths"]) && !is_array($langConfig["paths"]))) {
            $langConfig["paths"] = [];
        };
        $langConfig["paths"] = array_merge($langConfig["paths"], static::$paths);
        $this->config->set("lang", $langConfig);
        $locale = $this->config->get("app.locale");

        $this->application->bind('translator', function (Application $app) use ($langConfig, $locale) {
            $loader = new MultipleFileLoader($app['files'], $langConfig["paths"]);
            return new Translator($loader, $locale);
        });

    }

}