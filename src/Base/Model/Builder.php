<?php

namespace Structure\Base\Model;

use Illuminate\Database\Eloquent\Builder as LaravelEloquentBuilder;
use Illuminate\Support\Collection;

/**
 * Class Builder
 * @package Structure\Base\Model
 */
class Builder extends LaravelEloquentBuilder
{
    public static $recursionLevel = 0;


    /**
     * Переопределяем метод получения модели из запроса
     * пережеываем все в entity
     *
     * @param  array $columns
     * @return \Illuminate\Support\Collection|static[]
     */
    public function get($columns = ['*'])
    {
        $builder = $this->applyScopes();
        $builderModel = $builder->getModel();

        /** сдесь получается рекурсия для подгрузки завиимостей */
        if (count($models = $builder->getModels($columns)) > 0) {
            $models = $builder->eagerLoadRelations($models);
        }

        /**
         * Возвращаем модель для загрузки relations
         */
        if (static::$recursionLevel > 0) {
            return $builderModel->newCollection($models);
        }

        /**
         * Когда закончились все рекурсивные вызовы подгрузки зависимостей то
         * возвращаем entity
         */
        $resultArray = [];
        /** @var LaravelModel $model */
        foreach ($models as $model) {
            $entityClassName = $model->getEntityClassName();
            if (empty($entityClassName)) {
                array_push($resultArray, $model);
            } else {
                $entity = new $entityClassName($model->toArray());
                array_push($resultArray, $entity);
            }
        }

        return new Collection($resultArray);
    }

    public function eagerLoadRelations(array $models)
    {
        static::$recursionLevel++;
        $result = parent::eagerLoadRelations($models);
        static::$recursionLevel--;
        return $result;
    }

}