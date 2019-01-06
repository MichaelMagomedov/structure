<?php

namespace Structure\Impl\Module\Initer;

use Structure\Contract\Module\Initer\IniterFacade;
use Illuminate\Contracts\Foundation\Application;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;


/**
 * Класс инициализации провайдеров
 *
 * Class ProvidersIniter
 * @package Structure\Impl\Module\Initer
 */
class ProvidersIniter implements IniterFacade
{
    /**
     * @var Application $application
     */
    protected $application;

    /**
     * ProvidersIniter constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Метод инициализации провайдеров
     *
     * @param array $config
     * @throws ModuleNotCreatedException
     */
    public function init(array $config)
    {
        if (!empty($config["providers"])) {

            if (!is_array($config["providers"])) {
                throw new ModuleNotCreatedException("providers is not array");
            }

            $providers = $config["providers"];
            /** @var string $provider */
            foreach ($providers as $provider) {
                $this->application->register($provider);
            }

        }
    }
}