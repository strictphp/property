<?php

namespace Strict\Property\Utility;

use Strict\Property\Errors\IndeliblePropertyError;
use Strict\Property\Errors\ReadonlyPropertyError;
use Strict\Property\Errors\WriteonlyPropertyError;
use Strict\Property\Intermediate\PropertyDefinition;
use Strict\Property\Intermediate\PropertyRegister;
use Strict\Property\Intermediate\PropertyStorage;
use Strict\Property\Utility\ClassWithDisablePropertyInjectionTrait;
use Strict\Property\Errors\DisabledPropertyInjectionError;
use Strict\Property\Errors\UndefinedPropertyError;


/**
 * [Class] Strict Property Container
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
abstract class StrictPropertyContainer
    extends ClassWithDisablePropertyInjectionTrait
{
    abstract protected function registerProperty(PropertyRegister $propertyRegister): void;

    /**
     * @param string $propertyName
     * @return mixed
     */
    final protected function getPropertyDirectly(string $propertyName)
    {
        return $this->propertyStorage->getPropertyDirectly($propertyName);
    }

    /**
     * @param string $propertyName
     * @param        $value
     */
    final protected function setPropertyDirectly(string $propertyName, $value): void
    {
        $this->propertyStorage->setPropertyDirectly($propertyName, $value);
    }

    /**
     * StrictPropertyContainer constructor.
     */
    public function __construct()
    {
        if (!isset(self::$propertyDefinitions[static::class])) {
            $newDef = new PropertyDefinition;
            $this->registerProperty(new PropertyRegister($newDef));
            self::$propertyDefinitions[static::class] = $newDef;
        }
        $this->propertyStorage = new PropertyStorage(self::$propertyDefinitions[static::class], $this);
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @return bool
     */
    final public function __isset($name): bool
    {
        if ($this->propertyStorage->propertyExists($name)) {
            return true;
        }
        return parent::__isset($name);
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @throws IndeliblePropertyError
     * @throws UndefinedPropertyError
     */
    final public function __unset($name): void
    {
        if ($this->propertyStorage->propertyExists($name)) {
            throw new IndeliblePropertyError(static::class, $name);
        }
        parent::__unset($name);
    }

    /**
     * Magic method.
     *
     * @param string $name
     * @return mixed
     * @throws WriteonlyPropertyError
     * @throws UndefinedPropertyError
     */
    final public function __get($name)
    {
        if (!$this->propertyStorage->propertyExists($name)) {
            return parent::__get($name);
        }
        if (!$this->propertyStorage->getterAvailable($name)) {
            throw new WriteonlyPropertyError(static::class, $name);
        }
        return $this->propertyStorage->callGetter($name);
    }

    /**
     * Magic method.
     *
     * @param $name
     * @param $value
     * @throws ReadonlyPropertyError
     * @throws DisabledPropertyInjectionError
     */
    final public function __set($name, $value): void
    {
        if (!$this->propertyStorage->propertyExists($name)) {
            parent::__set($name, $value);
            return;
        }
        if (!$this->propertyStorage->setterAvailable($name)) {
            throw new ReadonlyPropertyError(static::class, $name);
        }
        $this->propertyStorage->callSetter($name, $value);
    }

    /** @var PropertyDefinition[] */
    private static $propertyDefinitions = [];

    /** @var PropertyStorage */
    private $propertyStorage;

    /**
     * Magic method.
     */
    public function __clone()
    {
        $this->propertyStorage = clone $this->propertyStorage;
        $this->propertyStorage->changeBind($this);
    }
}