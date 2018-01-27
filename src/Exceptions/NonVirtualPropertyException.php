<?php

namespace Strict\Property\Exceptions;

use Strict\Property\Exceptions\PropertyException;


/**
 * [Exception] Non-virtual Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class NonVirtualPropertyException
    extends PropertyException
{
    /**
     * @inheritdoc
     */
    protected static function generateMessage(string $propertyName): string
    {
        return "Non-virtual property: \${$propertyName}; any real property does not have the virtual getter or the virtual setter.";
    }
}