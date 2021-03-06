<?php
declare(strict_types=1);

namespace Strict\Property\Errors;

use Strict\Property\Errors\PropertyError;


/**
 * [Error] Indelible Property
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
class IndeliblePropertyError extends PropertyError
{
    protected static function generateMessage(string $className, string $propertyName): string
    {
        return "Indelible property: {$className}::\${$propertyName}";
    }
}
