<?php

namespace Structure\Base\Repository\Traits;


use Structure\Base\Entity\Entity;
use Structure\Base\Model\Model;

trait Updateable
{

    /** @var  Model $model */
    protected $model;

    public function update(Entity $entity):void
    {
        $attributes = $entity->toArray();
        $id = $attributes[$this->model->getKeyName()];
        $this->model->whereId($id)->update($attributes);
    }

}