<?php

namespace Structure\Contract\Module;

/**
 * Interface Module
 * @package Structure\Contract\Module
 */
interface Module
{

    /**
     * Инициализировать модуль
     * @return mixed
     */
    public function init();

}