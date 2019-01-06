<?php

namespace App\Module\Test\Service\Impl;

use App\Module\Test\Service\TestService;

class TestServiceImpl implements TestService
{

    public function test(): string
    {
        return trans("test.test.test");
    }
}