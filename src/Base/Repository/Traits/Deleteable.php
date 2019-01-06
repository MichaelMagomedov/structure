<?php

namespace Structure\Base\Repository\Traits;

use Structure\Base\Model\Model;

trait Deleteable
{

    /** @var  Model $model */
    protected $model;

    public function delete(int $id)
    {
        return $this->model->whereId($id)->delete();
    }

}