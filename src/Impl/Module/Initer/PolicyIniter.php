<?php

namespace Structure\Impl\Module\Initer;

use Structure\Contract\Module\Initer\IniterFacade;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Structure\Impl\Module\Exception\ModuleNotCreatedException;
use Illuminate\View\ViewServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Класс инициализации политик
 *
 * Class PolicyIniter
 * @package Structure\Impl\Module\Initer
 */
class PolicyIniter implements IniterFacade
{
    protected $gate;

    /**
     * ViewsIniter constructor.
     * @param Application $application
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(Application $application)
    {
        $this->gate = $application->get(Gate::class);
    }


    /**
     * @param array $config
     * @return mixed|void
     * @throws ModuleNotCreatedException
     */
    public function init(array $config)
    {
        if (!empty($config["policies"])) {

            if (!is_array($config["policies"])) {
                throw new ModuleNotCreatedException("policies is not array");
            }

            foreach ($config["policies"] as $modelClassName => $policyClassName) {
                $this->gate->policy($modelClassName, $policyClassName);
            }
        }
    }
}