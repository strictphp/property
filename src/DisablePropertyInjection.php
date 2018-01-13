<?php

namespace Strict\Property;

use Strict\Property\StandardPropertyAccess;
use Strict\Property\Errors\DisabledPropertyInjectionError;


/**
 * [ Trait ] Disable Property Injection
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
trait DisablePropertyInjection
{

    use StandardPropertyAccess;

    public function __set($n, $v)
    {
        throw new DisabledPropertyInjectionError(static::class, $n);
    }

}
