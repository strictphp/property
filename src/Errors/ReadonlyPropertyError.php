<?php
declare(strict_types=1);

namespace Strict\Property\Errors;

use Strict\Property\Errors\PropertyError;


/**
 * [Error] Readonly Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.1.0
 */
class ReadonlyPropertyError extends PropertyError
{
    protected static function generateMessage(string $className, string $propertyName): string
    {
        return "Readonly property: {$className}::\${$propertyName}";
    }
}
