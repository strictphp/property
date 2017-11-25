<?php

namespace Strict\Property\Errors;

use Strict\Property\Errors\UndefinedPropertyError;


/**
 * [ Error ] Dynamic Prperty Injection is Disabled
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
class DisabledPropertyInjectionError extends UndefinedPropertyError
{

    public function __construct(string $className)
    {
        parent::__construct("Class {$className} denies property injection");
    }

}
