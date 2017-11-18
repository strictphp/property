<?php

namespace Strict\Property;

use Strict\Property\Errors\UndefinedPropertyError;


/**
 * [ Trait ] Standard Property Access
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
trait StandardPropertyAccess
{

    public function __get($n)
    {
        throw new UndefinedPropertyError(static::class, $n);
    }

    public function __set($n, $v)
    {
        $this->{$n} = $v;
    }

    public function __isset($n)
    {
        return false;
    }

    public function __unset($n)
    {
        throw new UndefinedPropertyError(static::class, $n);
    }

}
