<?php

namespace Structure\Impl\Module\Initer\Traits;

use Structure\Impl\Module\Exception\ModuleNotCreatedException;

/**
 * Трейт проверки что имя не пустое
 * Trait ModuleHelpers
 * @package Structure\Impl\Module\Initer\Traits
 */
trait ModuleHelpers
{
    /**
     * Проерка что имя модуля не пустое
     *
     * @param array $config
     * @throws ModuleNotCreatedException
     */
    protected function checkModuleNameFromConfig(array $config)
    {
        if (empty($config["name"])) {
            throw  new ModuleNotCreatedException("empty module name from config");
        }
    }

    /**
     * Получить абсолютный путь до папки в модули по относительному
     *
     * @param array $configs
     * @param string $relativePath
     * @return string
     * @throws ModuleNotCreatedException
     */
    protected function getAbsolutePath(array $configs, string $relativePath): string
    {
        $this->checkModuleNameFromConfig($configs);
        $moduleName = ucfirst(mb_strtolower($configs["name"]));
        $relativePath = trim($relativePath, "/");
        $absolutePath = app_path("Module/$moduleName/$relativePath");
        return $absolutePath;
    }

    /**
     * Получить namespace модуля
     *
     * @param array $configs
     * @return string
     * @throws ModuleNotCreatedException
     */
    protected function getNamespace(array $configs): string
    {
        $moduleName = $this->getModuleName($configs);
        return "App\Module\\$moduleName";
    }

    /**
     * Получить имя модуля
     *
     * @param array $configs
     * @return string
     * @throws ModuleNotCreatedException
     */
    protected function getModuleName(array $configs): string
    {
        $this->checkModuleNameFromConfig($configs);
        $moduleName = ucfirst(mb_strtolower($configs["name"]));
        return $moduleName;
    }
}