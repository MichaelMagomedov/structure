<?php

namespace Structure\Contract\Module\Defer;

/**
 * Interface DeferObservable
 * @package Structure\Contract\Module\Defer
 */
interface DeferObservable
{

    /** установить обозреватель определеноого типа
     *
     * @param string $key
     * @param DeferObserver $observer
     */
    public static function setDeferIniter(string $key, DeferObserver $observer);

    /**
     * Выполнить все отложеные  действия
     * (Запускает только последние зарегистрированные инитеры каждого типа)
     */
    public static function runDeferActions();

}