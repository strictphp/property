<?php
declare(strict_types=1);

namespace Strict\Property\Errors;

use Strict\Property\Errors\UndefinedPropertyError;


/**
 * [Error] Dynamic Property Injection is Disabled
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 1.0.0
 */
class DisabledPropertyInjectionError extends UndefinedPropertyError
{
    /**
     * @inheritdoc
     */
    protected static function generateMessage(string $className, string $propertyName): string
    {
        return "Undefined property: {$className}::\${$propertyName}; dynamic property injection is disabled.";
    }
}
