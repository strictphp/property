<?php

namespace Strict\Property\Tests\Utility;

use PHPUnit\Framework\TestCase;
use Strict\Property\Errors\ReadonlyPropertyError;
use Strict\Property\Errors\UndefinedPropertyError;
use Strict\Property\Errors\WriteonlyPropertyError;


class ZZAutoPropertyTest
    extends TestCase
{
    /** @var ZZAutoPropertyMock */
    private $apm;

    public function setUp()
    {
        $this->apm = new ZZAutoPropertyMock;
    }

    public function testValue1()
    {
        $this->assertEquals(3, $this->apm->value1);
        $this->apm->value1 = 4;
    }

    public function testValue2()
    {
        $this->assertEquals(4, $this->apm->value2);

        $this->expectException(ReadonlyPropertyError::class);
        $this->apm->value2 = 3;
    }

    public function testValue3()
    {
        $this->apm->value3 = 3;

        $this->expectException(WriteonlyPropertyError::class);
        $this->apm->value3;
    }

    public function testUndefinedValue1()
    {
        $this->expectException(UndefinedPropertyError::class);
        $this->apm->undefined;
    }

    public function testUndefinedValue2()
    {
        $this->expectException(UndefinedPropertyError::class);
        $this->apm->undefined = 3;
    }

    public function testReadAndWrite()
    {
        $this->assertEquals(0, $this->apm->value4);
        $this->apm->value4 = 3;
        $this->assertEquals(3, $this->apm->value4);
    }
}