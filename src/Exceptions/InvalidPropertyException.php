<?php

namespace Strict\Property\Exceptions;

use Strict\Property\Exceptions\PropertyException;


/**
 * [Exception] Invalid Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class InvalidPropertyException
    extends PropertyException
{
    /**
     * @inheritdoc
     */
    protected static function generateMessage(string $propertyName): string
    {
        return "Invalid property: \${$propertyName}; at least one of getter and setter must be available.";
    }
}