<?php

namespace Strict\Property\Errors;

use Error;


/**
 * [Abstract Error] Property-related Error
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.5
 */
abstract class PropertyError extends Error
{
    /**
     * PropertyError constructor.
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
    abstract protected static function generateMessage(string $className, string $propertyName): string;
}