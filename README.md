# Property

```php
namespace Strict\Property {

    /**
     * Override __get, __set, __isset, __unset.
     * @throws UndefinedPropertyError
     */
    trait StandardPropertyAccess { }
    
    
    /**
     * Override __set.
     * @throws UndefinedPropertyError
     * @throws DisabledPropertyError
     */
    trait DisablePropertyInjection {
        use StandardPropertyAccess;
    }
    
}

namespace Strict\Property\Errors {

    // Thrown when an undefined property is tried to access.
    class UndefinedPropertyError extends \Error { }
    
    // Thrown when an undefined property is tried to set.
    class DisabledPropertyInjectionError extends \Error { }

}
```