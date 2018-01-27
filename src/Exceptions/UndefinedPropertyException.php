<?php
declare(strict_types=1);

namespace Strict\Property\Exceptions;

use Strict\Property\Exceptions\PropertyException;


/**
 * [Exception] Undefined Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class UndefinedPropertyException
    extends PropertyException
{
    /**
     * @inheritdoc
     */
    protected static function generateMessage(string $propertyName): string
    {
        return "Undefined Property: \${$propertyName}";
    }
}