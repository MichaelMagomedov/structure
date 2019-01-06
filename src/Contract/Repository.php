<?php

namespace Structure\Contract;

/**
 * Interface Repository
 * @package Structure\Contract
 */
interface Repository
{

    /**
     * устанавливаем модель для запроса
     *
     * @param $model
     * @return mixed
     */
    public function setModel($model);

    /**
     * Проверить тип моедил
     *
     * @param $model
     * @return mixed
     */
    public function checkModelType($model);
}