# Property

## Installation
`composer require strictphp/property`

## Basic Traits
```php
namespace Strict\Property;

/**
 * Override __get, __set, __isset, __unset.
 *
 * __get: throw UndefinedPropertyError
 * __set: add property dynamically
 * __isset: return null
 * __unset: throw UndefinedPropertyError
 *
 * @throws UndefinedPropertyError
 */
trait StandardPropertyAccess { }

/**
 * Override __set.
 *
 * __set: throw DisabledPropertyInjectionError
 *
 * @throws UndefinedPropertyError
 * @throws DisabledPropertyInjectionError
 */
trait DisablePropertyInjection {
    use StandardPropertyAccess;
}
```

Those two traits provides basic handlers for dynamic property operations.

## Utility
```php
namespace Strict\Property\Utility;

abstract class StrictPropertyContainer
{
    abstract protected function registerProperty(PropertyRegister $propertyRegister): void;
    final protected function getPropertyDirectly(string $propertyName): mixed { }
    final protected function setPropertyDirectly(string $propertyName, mixed $value): void { }
}
```

This abstract class provides strict property control. Here is an example of use:

```php
/**
 * @property string $firstName
 * @property string $lastName
 * @property-read string $fullName
 */
class MyClass
    extends StrictPropertyContainer
{
    protected function registerProperty(PropertyRegister $propertyRegister): void
    {
        $firstNameProperty = 'firstName';
        $lastNameProperty = 'lastName';
        $fullNameProperty = 'fullName';

        /*
         * PropertyRegister::newProperty(
         *     string $propertyName,
         *     bool $enableGet,
         *     bool $enableSet
         * ): self;
         */
        $propertyRegister->newProperty($firstNameProperty, true, true);
        $propertyRegister->addSetterHook($firstNameProperty, function (string $value, Closure $next): void {
            if (1 !== preg_match('@^[A-Z][a-z]{1,63}$@', $value)) {
                throw new Exception;
            }
            $next($value);
        });

        $propertyRegister->newProperty($lastNameProperty, true, true);
        $propertyRegister->addSetterHook($lastNameProperty, function (string $value, Closure $next): void {
            if (1 !== preg_match('@^[A-Z][a-z]{1,63}$@', $value)) {
                throw new Exception;
            }
            $next($value);
        });

        /*
         * PropertyRegister::newVirtualProperty(
         *     string $propertyName,
         *     ?Closure $getter,
         *     ?Closure $setter
         * ): self;
         */
        $propertyRegister->newVirtualProperty($fullNameProperty, function (): string {
            return "{$this->firstName} {$this->lastName}";
        }, null );
    }
}

$mc = new MyClass;
$mc->firstName = 'Smith';
$mc->lastName = 'John';
echo $mc->fullName; // John Smith

$mc->lastName = 'jOhn'; // an exception will be thrown
```

You may add hooks as many as you like.

```php
/**
 * @property-read int $value
 */
class MyClass
    extends StrictPropertyContainer
{
    public function __construct() {
        parent::__construct();
        $this->setPropertyDirectly('value', 4);
    }
    protected function registerProperty(PropertyRegister $propertyRegister): void
    {
        $propertyRegister->newProperty('value', true, false);
        $propertyRegister->addGetterHook('value', function (Closure $next): int {
            return $next() * 3;
        }); // Let's name this closure 'Closure 1'.
        $propertyRegister->addGetterHook('value', function (Closure $next): int {
            return $next() + 5;
        }); // Let's name this closure 'Closure 2'.
    }
}

$mc = new MyClass;
echo $mc->value;    // = 17
```
The original value was `4`. The value was multiplied by `3` in 'Closure 1' and then 'Closure 2' added `5`. `4 * 3 + 5 = 17`. In other words, the order of hooks followes First-in, Last-out principle.
