<?php
declare(strict_types=1);

namespace Strict\Property\Intermediate;

use Closure;
use Strict\Property\Intermediate\PropertyDefinition;


/**
 * [Class] Property Register
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class PropertyRegister
{
    /** @var PropertyDefinition */
    private $propertyDefinition;

    /**
     * PropertyRegister constructor.
     *
     * @param PropertyDefinition $propertyDefinition
     */
    public function __construct(PropertyDefinition $propertyDefinition)
    {
        $this->propertyDefinition = $propertyDefinition;
    }

    /**
     * @param string $propertyName
     * @param bool   $enableGet
     * @param bool   $enableSet
     * @return PropertyRegister
     */
    public function newProperty(string $propertyName, bool $enableGet, bool $enableSet): self
    {
        $this->propertyDefinition->newProperty($propertyName, $enableGet, $enableSet);
        return $this;
    }

    /**
     * @param string       $propertyName
     * @param Closure|null $getter = function () use ($this): mixed;
     * @param Closure|null $setter = function ($value) use ($this): void;
     * @return PropertyRegister
     */
    public function newVirtualProperty(string $propertyName, ?Closure $getter, ?Closure $setter): self
    {
        $this->propertyDefinition->newVirtualProperty($propertyName, $getter, $setter);
        return $this;
    }

    /**
     * Add a hook for setter with first in, last out rule.
     *
     * @param string  $propertyName
     * @param Closure $hook = function ($value, Closure $next($value): void) use ($this): void;
     * @return PropertyRegister
     */
    public function addSetterHook(string $propertyName, Closure $hook): self
    {
        $this->propertyDefinition->addSetterHook($propertyName, $hook);
        return $this;
    }

    /**
     * Add a hook for getter with first in, last out rule.
     *
     * @param string  $propertyName
     * @param Closure $hook = function (Closure $next(): mixed) use ($this): mixed;
     * @return PropertyRegister
     */
    public function addGetterHook(string $propertyName, Closure $hook): self
    {
        $this->propertyDefinition->addGetterHook($propertyName, $hook);
        return $this;
    }
}