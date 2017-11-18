<?php

namespace Strict\Property\Errors;

use Error;


class UndefinedPropertyError extends Error
{

    public function __construct(string $className, string $propertyName)
    {
        parent::__construct("Property {$className}::{$propertyName} is undefined.");
    }

}
