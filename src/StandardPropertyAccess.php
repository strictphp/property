<?php

namespace Strict\Property;

use Strict\Property\Errors\UndefinedPropertyError;


/**
 * [Trait] Standard Property Access
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
trait StandardPropertyAccess
{
    /**
     * Magic method.
     *
     * @param $name
     * @return mixed
     *
     * @throws UndefinedPropertyError
     */
    public function __get($name)
    {
        throw new UndefinedPropertyError(static::class, $name);
    }

    /**
     * Magic method.
     *
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    /**
     * Magic method.
     *
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return false;
    }

    /**
     * Magic method.
     *
     * @param $name
     * @return void
     *
     * @throws UndefinedPropertyError
     */
    public function __unset($name)
    {
        throw new UndefinedPropertyError(static::class, $name);
    }
}
