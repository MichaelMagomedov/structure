<?php

namespace App\Module\Test\Repository;

use Illuminate\Database\Eloquent\Collection;
use Structure\Contract\Repository;

interface TestRepository extends Repository
{
    public function test(): Collection;
}