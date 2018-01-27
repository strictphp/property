<?php
declare(strict_types=1);

namespace Strict\Property\Exceptions;

use LogicException;


/**
 * [Abstract Exception] Property-related Exception
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2017 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 2.0.0
 */
abstract class PropertyException
    extends LogicException
{
    /**
     * PropertyException constructor.
     *
     * @param $propertyName
     */
    final public function __construct($propertyName)
    {
        parent::__construct(static::generateMessage($propertyName));
    }

    /**
     * Generate the error message.
     *
     * @param string $propertyName
     * @return string
     */
    abstract protected static function generateMessage(string $propertyName): string;
}