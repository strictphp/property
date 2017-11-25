<?php

namespace Strict\Property\Errors;

use Error;


/**
 * [ Error ] Property is Readonly
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
class ReadonlyPropertyError extends Error
{

    public function __construct(string $className, string $propertyName)
    {
        parent::__construct("Property {$className}::{$propertyName} is readonly.");
    }

}
