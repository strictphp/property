<?php

namespace Strict\Property\Exceptions;

use Strict\Property\Exceptions\PropertyException;


/**
 * [Exception] Unavailable Operation on a Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class UnavailableOperationException
    extends PropertyException
{
    /**
     * @inheritdoc
     */
    protected static function generateMessage(string $propertyName): string
    {
        return "Unavailable operation on a property: \${$propertyName}";
    }
}