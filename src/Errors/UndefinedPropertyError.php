<?php

namespace Strict\Property\Errors;

use Strict\Property\Errors\PropertyError;


/**
 * [Error] Undefined Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
class UndefinedPropertyError extends PropertyError
{
    /**
     * @inheritdoc
     */
    protected static function generateMessage(string $className, string $propertyName): string
    {
        return "Undefined property: {$className}::\${$propertyName}";
    }
}
