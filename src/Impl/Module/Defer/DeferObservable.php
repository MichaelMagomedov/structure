<?php

namespace Structure\Impl\Module\Defer;

use \Structure\Contract\Module\Defer\DeferObservable as Contract;
use Structure\Contract\Module\Defer\DeferObserver;

/**
 * Клас для хранения обьектов с отложенной инициализацией
 *
 * Class DeferObservable
 * @package Structure\Impl\Module\Defer
 */
class DeferObservable implements Contract
{
    /**
     * @var array
     */
    protected static $observers = [];

    /** установить обьект отложено инициализирующий определенную компоненту модуля
     *
     * @param string $key
     * @param DeferObserver $observer
     */
    public static function setDeferIniter(string $key, DeferObserver $observer)
    {
        static::$observers[$key] = $observer;
    }

    /**
     * Выполнить все отложеные  инициализацзии
     */
    public static function runDeferActions()
    {
        /** @var DeferObserver $deferObserver */
        foreach (static::$observers as $deferObserver) {
            $deferObserver->runDeferAction();
        }
    }
}