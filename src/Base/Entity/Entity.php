<?php

namespace Structure\Base\Entity;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Structure\Base\Entity\Traits\EntityArrayable;
use Structure\Base\Entity\Traits\EntityJsonSerializable;
use Zend\Hydrator\ClassMethods;

class Entity implements JsonSerializable, Arrayable
{
    use EntityArrayable, EntityJsonSerializable;

    /**
     * Автозаполнение entity
     *
     * Entity constructor.
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        if (!empty($data)) {
            $hydrator = new ClassMethods();
            $hydrator->hydrate($data, $this);
        }
    }
}