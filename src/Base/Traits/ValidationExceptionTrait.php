<?php

namespace Structure\Base\Traits;

trait ValidationExceptionTrait
{
    public function __construct(array $errors)
    {
        foreach ($errors as $fieldName => $fieldErrors) {
            foreach ($fieldErrors as $errorName)
                return parent::__construct(400, trans("root.error.$errorName", [
                    "fieldName" => $fieldName
                ]));
        }
    }
}