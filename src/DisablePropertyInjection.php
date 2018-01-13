<?php

namespace Strict\Property;

use Strict\Property\StandardPropertyAccess;
use Strict\Property\Errors\DisabledPropertyInjectionError;


/**
 * [Trait] Disable Property Injection
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
trait DisablePropertyInjection
{
    use StandardPropertyAccess;

    /**
     * @inheritdoc
     *
     * @throws DisabledPropertyInjectionError
     */
    public function __set($name, $value): void
    {
        throw new DisabledPropertyInjectionError(static::class, $name);
    }
}
