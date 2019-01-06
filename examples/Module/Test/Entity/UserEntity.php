<?php

namespace App\Module\Test\Entity;

use Structure\Base\Entity\Entity;
use Structure\Base\Traits\EntityJsonSerializable;

class UserEntity extends Entity
{
    private $id;

    private $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
