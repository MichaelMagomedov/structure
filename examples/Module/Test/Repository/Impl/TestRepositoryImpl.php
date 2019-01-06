<?php

namespace App\Module\Test\Repository\Impl;

use App\Module\Test\Entity\UserEntity;
use App\Module\Test\Repository\TestRepository;
use App\Module\Test\UserModel;
use Structure\Base\Repository\Repository;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TestRepositoryImpl
 * @package App\Module\Repository\Impl
 */
class TestRepositoryImpl extends Repository implements TestRepository
{
    /**
     * @var string
     */
    protected $modelClassName = UserModel::class;

    public function test(): Collection
    {
        return $this->model->all();
    }
}