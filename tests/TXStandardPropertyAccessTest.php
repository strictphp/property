<?php

namespace Strict\Property\Tests;

use PHPUnit\Framework\TestCase;
use Strict\Property\StandardPropertyAccess;
use Strict\Property\Errors\UndefinedPropertyError;


class TXStandarPropertyAccessTest extends TestCase
{

    use StandardPropertyAccess;

    public function testGet()
    {
        $this->expectException(UndefinedPropertyError::class);
        $t = $this->undefinedProperty;
    }

    public function testSet()
    {
        $this->undefinedProperty = 3;
        $this->assertEquals(3, $this->undefinedProperty);
    }

    public function testIsset()
    {
        $this->assertFalse(isset($this->undefinedProperty));
    }

    public function testUnset()
    {
        $this->expectException(UndefinedPropertyError::class);
        unset($this->undefinedProperty);
    }

}
