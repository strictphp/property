<?php

namespace Strict\Property\Errors;

use Error;


class DisabledPropertyInjectionError extends Error
{

    public function __construct(string $className)
    {
        parent::__construct("Class {$className} denies property injection");
    }

}
