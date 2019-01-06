<?php

namespace Structure\Contract\Module\Initer;

/**
 * Interface IniterFacade
 * @package Structure\Contract\Module\Initer
 */
interface IniterFacade
{

    /**
     * Инициализировать компоненту модуля
     * @param array $config
     * @return mixed
     */
    public function init(array $config);

}