<?php

namespace Structure\Base\Model;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model as LaravelModel;

/**
 * Class Model
 * @package Structure\Base\Repository
 */
class Model extends LaravelModel
{
    /**
     * Класс entity который будет возвращать модуль
     *
     * @var string
     */
    protected $entityClassName;

    /**
     * убирвем языковые переменные
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Делаем fillable все кроме id
     *
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * @return string
     */
    public function getEntityClassName(): ?string
    {
        return $this->entityClassName;
    }

    /**
     * @param string $entityClassName
     */
    public function setEntityClassName(?string $entityClassName): void
    {
        $this->entityClassName = $entityClassName;
    }


    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder|void|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function toEntity()
    {
        $modelArrayData = $this->toArray();
        if(empty($this->entityClassName)){
            throw new \Exception("empty entity class name");
        }
        return new $this->entityClassName($modelArrayData);
    }

}