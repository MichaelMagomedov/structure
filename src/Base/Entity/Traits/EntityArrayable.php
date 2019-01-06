<?php

namespace Structure\Base\Entity\Traits;


use Zend\Hydrator\ClassMethods;

trait EntityArrayable
{
    /**
     * Превращает не null поля entity в ассоциативный массив
     *
     * @return array
     * @throws \ReflectionException
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($this);
        $result = [];
        foreach ($data as $key => $value) {
            if (!is_null($value) && !is_array($value) && !is_object($value)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}