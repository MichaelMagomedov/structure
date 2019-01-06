<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 30.08.18
 * Time: 15:01
 */

namespace Structure\Base\Repository\Traits;


use Structure\Base\Entity\Entity;
use Structure\Base\Model\Model;

trait Saveable
{
    /** @var  Model $model */
    protected $model;

    public function save(Entity $entity): Entity
    {
        return $this->model->create($entity->toArray())->toEntity();
    }

}