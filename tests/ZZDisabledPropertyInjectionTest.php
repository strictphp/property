<?php

namespace Strict\Property\Tests;

use PHPUnit\Framework\TestCase;
use Strict\Property\DisablePropertyInjection;
use Strict\Property\Errors\DisabledPropertyInjectionError;


class ZZDisabledPropertyInjectionTest extends TestCase
{
    use DisablePropertyInjection;

    public function testSet()
    {
        $this->expectException(DisabledPropertyInjectionError::class);
        $this->undefinedProperty = 3;
    }
}
