<?php

namespace Structure\Base\Repository;

use Structure\Base\Model\Model;
use \Structure\Contract\Repository as Contract;

/**
 * Базовый класс репозитория
 *
 * Class Repository
 * @package Structure\Base\Repository
 */
class Repository implements Contract
{
    /**
     * Обьект модель для запросов
     */
    protected $model;

    /**
     * Класс модели для запросов
     *
     * @var string
     */
    protected $modelClassName;

    /**
     * устанавливаем модель для запроса
     *
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    public function setModel($model)
    {
        $this->checkModelType($model);
        $this->model = $model;
    }

    /**
     * Проверить тип моедил
     *
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    public function checkModelType($model)
    {
        if (!$model instanceof Model) {
            throw new \Exception("model type is not avaliable");
        }
    }

    /**
     * дать класс модели
     *
     * @return string
     */
    public function getModelClassName(): string
    {
        return $this->modelClassName;
    }
}