<?php

namespace Strict\Property\Errors;

use Error;


/**
 * [Error] Undefined Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
class UndefinedPropertyError extends Error
{
    /**
     * UndefinedPropertyError constructor.
     *
     * @param string $className
     * @param string $propertyName
     */
    final public function __construct(string $className, string $propertyName)
    {
        parent::__construct(static::generateMessage($className, $propertyName));
    }

    /**
     * This method generates the error message.
     *
     * @param string $className
     * @param string $propertyName
     * @return string
     */
    protected static function generateMessage(string $className, string $propertyName): string
    {
        return "Undefined property: {$className}::\${$propertyName}";
    }
}
