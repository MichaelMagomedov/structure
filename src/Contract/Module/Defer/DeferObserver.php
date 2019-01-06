<?php

namespace Structure\Contract\Module\Defer;

/**
 * Interface DeferObserver
 * @package Structure\Contract\Module\Defer
 */
interface DeferObserver
{

    /**
     * выполнить отложеное действие
     */
    public function runDeferAction();

}