<?php

namespace Structure\Provider;

use App\Module\Guard\Entity\UserEntity;
use App\Module\Guard\Model\UserModel;
use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->extend(GateContract::class, function ($gate, $app) {
            return new Gate($app, function () use ($app) {
                /** @var UserModel $userModel */
                $userModel = call_user_func($app['auth']->userResolver());

                return ($userModel) ? new UserEntity($userModel->toArray()) : null;
            });
        });
    }
}