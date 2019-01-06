<?php

namespace Structure\Base\Traits;

trait AccessExceptionTrait
{
    protected $objectAlias;

    public function __construct()
    {
        parent::__construct(401, trans('root.error.access', [
            "object" => $this->objectAlias
        ]));
    }
}