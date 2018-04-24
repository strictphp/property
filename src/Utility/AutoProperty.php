<?php
declare(strict_types=1);

namespace Strict\Property\Utility;

use Strict\Property\Errors\IndeliblePropertyError;
use Strict\Property\Errors\ReadonlyPropertyError;
use Strict\Property\Errors\UndefinedPropertyError;
use Strict\Property\Errors\WriteonlyPropertyError;


/**
 * [Trait] Auto Property Read & Write
 *
 * All setters and getters become accessible via property.
 *
 * class T { use AutoProperty; public function getValue(): int { return 3; } }
 * $t = new T;
 * $t->value;   // 3
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 3.0.0
 */
trait AutoProperty
{
    /**
     * @deprecated
     * @internal
     */
    private function ___auto_property_marker() { }

    /**
     * @param string $name
     * @return mixed
     *
     * @throws UndefinedPropertyError
     * @throws WriteonlyPropertyError
     *
     * @deprecated
     * @internal
     */
    public function __get(string $name)
    {
        $setter = [$this, 'set' . strtolower($name)];
        $getter = [$this, 'get' . strtolower($name)];

        if (is_callable($getter)) {
            return $getter();
        } else if (is_callable($setter)) {
            throw new WriteonlyPropertyError(get_class($this), $name);
        } else {
            throw new UndefinedPropertyError(get_class($this), $name);
        }
    }

    /**
     * @param string $name
     * @param $value
     *
     * @throws UndefinedPropertyError
     * @throws ReadonlyPropertyError
     *
     * @deprecated
     * @internal
     */
    public function __set(string $name, $value): void
    {
        $setter = [$this, 'set' . strtolower($name)];
        $getter = [$this, 'get' . strtolower($name)];

        if (is_callable($setter)) {
            $setter($value);
        } else if (is_callable($getter)) {
            throw new ReadonlyPropertyError(get_class($this), $name);
        } else {
            throw new UndefinedPropertyError(get_class($this), $name);
        }
    }

    /**
     * @param string $name
     * @return bool
     *
     * @deprecated
     * @internal
     */
    public function __isset(string $name): bool
    {
        $setter = [$this, 'set' . strtolower($name)];
        $getter = [$this, 'get' . strtolower($name)];

        return is_callable($setter) || is_callable($getter);
    }

    /**
     * @param string $name
     *
     * @throws UndefinedPropertyError
     * @throws IndeliblePropertyError
     *
     * @deprecated
     * @internal
     */
    public function __unset(string $name): void
    {
        $setter = [$this, 'set' . strtolower($name)];
        $getter = [$this, 'get' . strtolower($name)];

        if (is_callable($setter) || is_callable($getter)) {
            throw new IndeliblePropertyError(get_class($this), $name);
        } else {
            throw new UndefinedPropertyError(get_class($this), $name);
        }
    }
}