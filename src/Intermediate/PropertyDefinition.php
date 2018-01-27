<?php
declare(strict_types=1);

namespace Strict\Property\Intermediate;

use Closure;
use Strict\Property\Exceptions\DuplicatePropertyException;
use Strict\Property\Exceptions\InvalidPropertyException;
use Strict\Property\Exceptions\NonVirtualPropertyException;
use Strict\Property\Exceptions\UnavailableOperationException;
use Strict\Property\Exceptions\UndefinedPropertyException;


/**
 * [Class] Property Definition
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class PropertyDefinition
{
    private const PROPERTY_VIRTUAL = 1;
    private const PROPERTY_REAL    = 2;

    /**
     * @var int[] $propertyName => PROPERTY_***
     */
    private $properties = [];

    /**
     * @var Closure[] $propertyName => $virtualGetter
     */
    private $virtualGetters = [];

    /**
     * @var Closure[] $propertyName => $virtualSetter
     */
    private $virtualSetters = [];

    /**
     * @var bool[] $propertyName => $setAvailable
     */
    private $realSetAvailable = [];

    /**
     * @var bool[] $propertyName => $getAvailable
     */
    private $realGetAvailable = [];

    /**
     * @var Closure[][] $propertyName => [$setterHook, ...]
     */
    private $setterHooks = [];

    /**
     * @var Closure[][] $propertyName => [$getterHook, ...]
     */
    private $getterHooks = [];

    /**
     * @param string $propertyName
     * @param bool   $enableGet
     * @param bool   $enableSet
     *
     * @throws DuplicatePropertyException
     * @throws InvalidPropertyException
     */
    public function newProperty(string $propertyName, bool $enableGet, bool $enableSet): void
    {
        if ($this->propertyExists($propertyName)) {
            throw new DuplicatePropertyException($propertyName);
        }
        if (!$enableGet && !$enableSet) {
            throw new InvalidPropertyException($propertyName);
        }
        $this->properties[$propertyName] = self::PROPERTY_REAL;
        $this->realGetAvailable[$propertyName] = $enableGet;
        $this->realSetAvailable[$propertyName] = $enableSet;
        $this->setterHooks[$propertyName] = [];
        $this->getterHooks[$propertyName] = [];
    }

    /**
     * @param string       $propertyName
     * @param Closure|null $getter
     * @param Closure|null $setter
     *
     * @throws DuplicatePropertyException
     * @throws InvalidPropertyException
     */
    public function newVirtualProperty(string $propertyName, ?Closure $getter, ?Closure $setter): void
    {
        if ($this->propertyExists($propertyName)) {
            throw new DuplicatePropertyException($propertyName);
        }
        if (is_null($getter) && is_null($setter)) {
            throw new InvalidPropertyException($propertyName);
        }
        $this->properties[$propertyName] = self::PROPERTY_VIRTUAL;
        $this->virtualGetters[$propertyName] = $getter;
        $this->virtualSetters[$propertyName] = $setter;
        $this->setterHooks[$propertyName] = [];
        $this->getterHooks[$propertyName] = [];
    }

    /**
     * @param string  $propertyName
     * @param Closure $hook
     *
     * @throws UndefinedPropertyException
     */
    public function addSetterHook(string $propertyName, Closure $hook): void
    {
        $this->existsOrFail($propertyName);
        $this->existingPropertySetterAvailableOrFail($propertyName);
        $this->setterHooks[$propertyName][] = $hook;
    }

    /**
     * @param string  $propertyName
     * @param Closure $hook
     */
    public function addGetterHook(string $propertyName, Closure $hook): void
    {
        $this->existsOrFail($propertyName);
        $this->existingPropertyGetterAvailableOrFail($propertyName);
        $this->getterHooks[$propertyName][] = $hook;
    }

    /**
     * @param string $propertyName
     * @return Closure = function () bound (StrictPropertyContainer): mixed;
     */
    public function getVirtualGetter(string $propertyName): Closure
    {
        $this->existsOrFail($propertyName);
        $this->existingPropertyVirtualOrFail($propertyName);
        $this->existingPropertyGetterAvailableOrFail($propertyName);
        return $this->virtualGetters[$propertyName];
    }

    /**
     * @param string $propertyName
     * @return Closure[] = function (Closure $next(): mixed) bound (StrictPropertyContainer): mixed;
     */
    public function getGetterHooks(string $propertyName): array
    {
        $this->existsOrFail($propertyName);
        $this->existingPropertyGetterAvailableOrFail($propertyName);
        return $this->getterHooks[$propertyName];
    }

    /**
     * @param string $propertyName
     * @return Closure = function ($value) bound (StrictPropertyContainer): void;
     */
    public function getVirtualSetter(string $propertyName): Closure
    {
        $this->existsOrFail($propertyName);
        $this->existingPropertyVirtualOrFail($propertyName);
        $this->existingPropertySetterAvailableOrFail($propertyName);
        return $this->virtualSetters[$propertyName];
    }

    /**
     * @param string $propertyName
     * @return Closure[] = function ($value, Closure $next($value): void) bound (StrictPropertyContainer): void;
     */
    public function getSetterHooks(string $propertyName): array
    {
        $this->existsOrFail($propertyName);
        $this->existingPropertySetterAvailableOrFail($propertyName);
        return $this->setterHooks[$propertyName];
    }

    /* ------------------------------------------------------------------------
     * User Level Boolean Functions
     * --------------------------------------------------------------------- */

    /**
     * Tell whether or not a property exists.
     *
     * @param string $propertyName
     * @return bool
     */
    public function propertyExists(string $propertyName): bool
    {
        return isset($this->properties[$propertyName]);
    }

    /**
     * Tell whether or not a property is virtual.
     *
     * @param string $propertyName
     * @return bool
     */
    public function isVirtual(string $propertyName): bool
    {
        $this->existsOrFail($propertyName);
        return $this->isExistingPropertyVirtual($propertyName);
    }

    /**
     * Tell whether or not the setter function for a property is available.
     *
     * @param string $propertyName
     * @return bool
     */
    public function setterAvailable(string $propertyName): bool
    {
        $this->existsOrFail($propertyName);
        return $this->isExistingPropertySetterAvailable($propertyName);
    }

    /**
     * Tell whether or not the getter function for a property is available.
     *
     * @param string $propertyName
     * @return bool
     */
    public function getterAvailable(string $propertyName): bool
    {
        $this->existsOrFail($propertyName);
        return $this->isExistingPropertyGetterAvailable($propertyName);
    }

    /* ------------------------------------------------------------------------
     * True or Fail functions
     * --------------------------------------------------------------------- */

    /**
     * Fail if a property does not exist.
     *
     * @param string $propertyName
     *
     * @throws UndefinedPropertyException
     */
    private function existsOrFail(string $propertyName): void
    {
        if (!$this->propertyExists($propertyName)) {
            throw new UndefinedPropertyException($propertyName);
        }
    }

    /**
     * Fail if an existing property is not virtual.
     *
     * @param string $propertyName
     *
     * @throws NonVirtualPropertyException
     */
    private function existingPropertyVirtualOrFail(string $propertyName): void
    {
        assert($this->propertyExists($propertyName));
        if (!$this->isExistingPropertyVirtual($propertyName)) {
            throw new NonVirtualPropertyException($propertyName);
        }
    }

    /**
     * Fail if the setter of an existing property is not available.
     *
     * @param string $propertyName
     * @return bool
     *
     * @throws UnavailableOperationException
     */
    private function existingPropertySetterAvailableOrFail(string $propertyName): void
    {
        assert($this->propertyExists($propertyName));
        if (!$this->isExistingPropertySetterAvailable($propertyName)) {
            throw new UnavailableOperationException($propertyName);
        }
    }

    /**
     * Fail if the getter of an existing property is not available.
     *
     * @param string $propertyName
     * @return bool
     *
     * @throws UnavailableOperationException
     */
    private function existingPropertyGetterAvailableOrFail(string $propertyName): void
    {
        assert($this->propertyExists($propertyName));
        if (!$this->isExistingPropertyGetterAvailable($propertyName)) {
            throw new UnavailableOperationException($propertyName);
        }
    }

    /* ------------------------------------------------------------------------
     * Low Level Boolean Functions
     * --------------------------------------------------------------------- */

    /**
     * Tell whether or not an existing property is virtual.
     *
     * @param string $propertyName
     * @return bool
     */
    private function isExistingPropertyVirtual(string $propertyName): bool
    {
        assert($this->propertyExists($propertyName));
        return $this->properties[$propertyName] === self::PROPERTY_VIRTUAL;
    }

    /**
     * Tell the availability of the the getter function for an existing property.
     *
     * @param string $propertyName
     * @return bool
     */
    private function isExistingPropertySetterAvailable(string $propertyName): bool
    {
        assert($this->propertyExists($propertyName));
        if ($this->isExistingPropertyVirtual($propertyName)) {
            return !is_null($this->virtualSetters[$propertyName]);
        } else {
            return $this->realSetAvailable[$propertyName];
        }
    }

    /**
     * Tell the availability of the the getter function for an existing property.
     *
     * @param string $propertyName
     * @return bool
     */
    private function isExistingPropertyGetterAvailable(string $propertyName): bool
    {
        assert($this->propertyExists($propertyName));
        if ($this->isExistingPropertyVirtual($propertyName)) {
            return !is_null($this->virtualGetters[$propertyName]);
        } else {
            return $this->realGetAvailable[$propertyName];
        }
    }
}