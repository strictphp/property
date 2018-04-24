<?php
declare(strict_types=1);

namespace Strict\Property\Utility;


/**
 * [Trait] Auto Property Require
 *
 * Traits should use this trait instead of AutoProperty to avoid duplicate use of AutoProperty.
 * Classes using your trait which uses AutoPropertyRequire must use AutoProperty;
 *
 * @author Showsay You <akizuki.c10.l65@gmail.com>
 * @copyright 2018 Strict PHP Project. All Rights Reserved.
 * @package strictphp/property
 * @since 3.0.0
 */
trait AutoPropertyRequire
{
    /**
     * @deprecated
     * @internal
     */
    abstract protected function ___auto_property_marker();
}