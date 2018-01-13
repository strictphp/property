<?php

namespace Strict\Property\Utility;

use Strict\Property\Utility\ClassWithDisablePropertyInjection;
use Strict\Property\Errors\ReadonlyPropertyError;


/**
 * [Container] Readonly Property Container
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.1.0
 */
abstract class ReadonlyPropertyContainer
    extends ClassWithDisablePropertyInjection
{
    /**
     * This method sets the value of a read-only property.
     *
     * @param string $name
     * @param mixed  $value
     * @return void
     */
    protected function setReadonlyProperty(string $name, $value)
    {
        $this->readonlyValues[$name] = $value;
    }

    /**
     * This method removes a read-only property.
     *
     * @param string $name
     * @return void
     */
    protected function unsetReadonlyProperty(string $name)
    {
        if ($this->issetReadonlyProperty($name)) {
            unset($this->readonlyValues[$name]);
        }
    }

    /**
     * This method tells whether a read-only property exists or not.
     *
     * @param string $name
     * @return bool
     */
    protected function issetReadonlyProperty(string $name): bool
    {
        return array_key_exists($name, $this->readonlyValues);
    }

    /**
     * This method returns the array of read-only values.
     *
     * @return array
     *
     * @since 1.3.0
     */
    protected function getReadonlyPropertyAll(): array
    {
        return $this->readonlyValues;
    }
    
    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        if ($this->issetReadonlyProperty($name)) {
            return $this->readonlyValues[$name];
        }

        return parent::__get($name);
    }

    /**
     * @inheritdoc
     *
     * @throws ReadonlyPropertyError
     */
    public function __set($name, $value): void
    {
        if ($this->issetReadonlyProperty($name)) {
            throw new ReadonlyPropertyError(static::class, $name);
        }
        parent::__set($name, $value);
    }

    /**
     * @inheritdoc
     */
    public function __isset($name): bool
    {
        return $this->issetReadonlyProperty($name) || parent::__isset($name);
    }

    /**
     * @inheritdoc
     *
     * @throws ReadonlyPropertyError
     */
    public function __unset($name): void
    {
        if ($this->issetReadonlyProperty($name)) {
            throw new ReadonlyPropertyError(static::class, $name);
        }
        parent::__unset($name);
    }

    /**
     * Magic method.
     */
    public function __clone()
    {
        $this->readonlyValues = self::cloneArray($this->readonlyValues);
    }

    /**
     * This method copies an array. All elements of the array will be cloned.
     *
     * @param array $source
     * @return array
     */
    private static function cloneArray(array $source): array
    {
        $ret = [];
        foreach ($source as $key => $value) {
            if (is_array($value)) {
                $ret[$key] = self::cloneArray($value);
            } else if (is_object($value)) {
                $ret[$key] = clone $value;
            } else {
                $ret[$key] = $value;
            }
        }
        return $ret;
    }

    /** @var array */
    private $readonlyValues = [];
}
