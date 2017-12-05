<?php

namespace Strict\Property\Utility;

use Strict\Property\Utility\ClassWithDisablePropertyInjection;
use Strict\Property\Errors\ReadonlyPropertyError;


/**
 * [ Container ] Readonly Property Container
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package strictphp/property
 * @since 1.1.0
 */
abstract class ReadonlyPropertyContainer extends ClassWithDisablePropertyInjection
{

    private $readonlyValues = [];

    protected function setReadonlyProperty(string $name, $value)
    {
        $this->readonlyValues[$name] = $value;
    }

    protected function unsetReadonlyProperty(string $name)
    {
        if ($this->issetReadonlyProperty($name)) {
            unset($this->readonlyValues[$name]);
        }
    }

    protected function issetReadonlyProperty(string $name)
    {
        return array_key_exists($name, $this->readonlyValues);
    }

    public function __get($n)
    {
        if ($this->issetReadonlyProperty($n)) {
            return $this->readonlyValues[$n];
        }

        return parent::__get($n);
    }

    public function __set($n, $v)
    {
        if ($this->issetReadonlyProperty($n)) {
            throw new ReadonlyPropertyError(static::class, $n);
        }
        parent::__set($n, $v);
    }

    public function __isset($n)
    {
        return $this->issetReadonlyProperty($n) || parent::__isset($n);
    }

    public function __unset($n)
    {
        if ($this->issetReadonlyProperty($n)) {
            throw new ReadonlyPropertyError(static::class, $n);
        }
        parent::__unset($n);
    }

}
