<?php

namespace Strict\Property\Tests\Utility;

use PHPUnit\Framework\TestCase;
use Strict\Property\Tests\Utility\TXContainerMock;
use Strict\Property\Errors\ReadonlyPropertyError;
use Strict\Property\Errors\UndefinedPropertyError;
use Strict\Property\Errors\DisabledPropertyInjectionError;


class TXReadonlyPropertyContainerTest extends TestCase
{

    /** @var TXContainerMock */
    private $cm;

    public function setUp()
    {
        $this->cm = new TXContainerMock;
    }

    public function testGet()
    {
        $this->assertEquals(29, $this->cm->intValue);
    }

    public function testSet()
    {
        $this->expectException(ReadonlyPropertyError::class);
        $this->cm->intValue = 3;
    }

    public function testUnset()
    {
        $this->expectException(ReadonlyPropertyError::class);
        unset($this->cm->intValue);
    }

    public function testIsset()
    {
        $this->assertTrue(isset($this->cm->intValue));
    }

    public function testUndefinedGet()
    {
        $this->expectException(UndefinedPropertyError::class);
        $this->cm->undefined;
    }

    public function testUndefinedIsset()
    {
        $this->assertFalse(isset($this->cm->undefined));
    }

    public function testUndefinedUnset()
    {
        $this->expectException(UndefinedPropertyError::class);
        unset($this->cm->undefined);
    }

    public function testUndefinedSet()
    {
        $this->expectException(DisabledPropertyInjectionError::class);
        $this->cm->undefined = 3;
    }

}
