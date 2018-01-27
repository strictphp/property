<?php
declare(strict_types=1);

namespace Strict\Property\Intermediate;

use Strict\Property\Intermediate\PropertyDefinition;


/**
 * [Class] Property Storage
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class PropertyStorage
{
    /** @var PropertyDefinition */
    private $definition;

    /** @var array */
    private $properties = [];

    /** @var object|null */
    private $instance;

    /**
     * PropertyStorage constructor.
     *
     * @param PropertyDefinition $pd
     * @param object             $bind
     */
    public function __construct(PropertyDefinition $pd, object $bind)
    {
        $this->definition = $pd;
        $this->instance = $bind;
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function propertyExists(string $propertyName): bool
    {
        return $this->definition->propertyExists($propertyName);
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function setterAvailable(string $propertyName): bool
    {
        return $this->definition->setterAvailable($propertyName);
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function getterAvailable(string $propertyName): bool
    {
        return $this->definition->getterAvailable($propertyName);
    }

    /**
     * @param string $propertyName
     * @param mixed  $value
     */
    public function callSetter(string $propertyName, $value): void
    {
        assert($this->propertyExists($propertyName));   // Guaranteed by StrictPropertyContainer
        assert($this->setterAvailable($propertyName));  // Guaranteed by StrictPropertyContainer

        if (!$this->definition->isVirtual($propertyName)) {
            $setterClosure = function ($value) use ($propertyName) {
                $this->setPropertyDirectly($propertyName, $value);
            };
        } else {
            $setterClosure = $this->definition->getVirtualSetter($propertyName)->bindTo($this->instance);
        }

        $rawHooks = $this->definition->getSetterHooks($propertyName);
        $num = count($rawHooks);

        if ($num === 0) {
            $setterClosure($value);
            return;
        }

        $hookArgument = [0 => $setterClosure];
        for ($i = 0; $i < $num; $i++) {
            $next = $hookArgument[$i];
            $current = $rawHooks[$i]->bindTo($this->instance);
            $hookArgument[$i + 1] = function ($value) use ($next, $current) {
                $current($value, $next);
            };
        }

        $hookArgument[$num]($value);
    }

    /**
     * @param string $propertyName
     * @return mixed
     */
    public function callGetter(string $propertyName)
    {
        assert($this->propertyExists($propertyName));   // Guaranteed by StrictPropertyContainer
        assert($this->getterAvailable($propertyName));  // Guaranteed by StrictPropertyContainer

        if (!$this->definition->isVirtual($propertyName)) {
            $getterClosure = function () use ($propertyName) {
                return $this->getPropertyDirectly($propertyName);
            };
        } else {
            $getterClosure = $this->definition->getVirtualGetter($propertyName)->bindTo($this->instance);
        }

        $rawHooks = $this->definition->getGetterHooks($propertyName);
        $num = count($rawHooks);

        if ($num === 0) {
            return $getterClosure();
        }

        $hookArgument = [0 => $getterClosure];
        for ($i = 0; $i < $num; $i++) {
            $next = $hookArgument[$i];
            $current = $rawHooks[$i]->bindTo($this->instance);
            $hookArgument[$i + 1] = function () use ($next, $current) {
                return $current($next);
            };
        }

        return $hookArgument[$num]();
    }

    /**
     * @param string $propertyName
     * @return mixed
     */
    public function getPropertyDirectly(string $propertyName)
    {
        return $this->properties[$propertyName] ?? null;
    }

    /**
     * @param string $propertyName
     * @param mixed  $value
     */
    public function setPropertyDirectly(string $propertyName, $value): void
    {
        $this->properties[$propertyName] = $value;
    }

    /**
     * Magic method.
     */
    public function __clone()
    {
        foreach ($this->properties as $key => $value) {
            if (is_object($value)) {
                $this->properties[$key] = clone $value;
            }
        }
        $this->instance = null;
    }

    /**
     * @param object $bind
     */
    public function changeBind(object $bind): void
    {
        $this->instance = $bind;
    }
}