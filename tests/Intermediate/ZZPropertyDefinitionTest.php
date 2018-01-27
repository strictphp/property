<?php

namespace Strict\Property\Tests\Intermediate;

use PHPUnit\Framework\TestCase;
use Strict\Property\Exceptions\DuplicatePropertyException;
use Strict\Property\Exceptions\InvalidPropertyException;
use Strict\Property\Exceptions\NonVirtualPropertyException;
use Strict\Property\Exceptions\UnavailableOperationException;
use Strict\Property\Intermediate\PropertyDefinition;


class ZZPropertyDefinitionTest
    extends TestCase
{
    /** @var PropertyDefinition */
    private $pd;

    private const RP_NAME = 'realProperty';
    private const VP_NAME = 'virtualProperty';

    public function setUp()
    {
        $this->pd = new PropertyDefinition;
        $this->pd->newProperty(self::RP_NAME, false, true);
        $this->pd->newVirtualProperty(self::VP_NAME, function () {
            return 33 - 4;
        }, null);
    }

    public function testNewProperty()
    {
        $name = self::RP_NAME;
        $this->assertTrue($this->pd->propertyExists($name));
        $this->assertFalse($this->pd->isVirtual($name));
        $this->assertTrue($this->pd->setterAvailable($name));
        $this->assertFalse($this->pd->getterAvailable($name));
        $this->assertEquals([], $this->pd->getSetterHooks($name));

        $cls1 = function () {
            return 33;
        };
        $cls2 = function () {
            return 4;
        };

        $this->pd->addSetterHook($name, $cls1);
        $this->pd->addSetterHook($name, $cls2);

        $hooks = $this->pd->getSetterHooks($name);
        $this->assertEquals(33, $hooks[0]());
        $this->assertEquals(4, $hooks[1]());
    }

    public function testRealPropertyException1()
    {
        $this->expectException(UnavailableOperationException::class);
        $this->pd->addGetterHook(self::RP_NAME, function () {
        });
    }

    public function testRealPropertyException2()
    {
        $this->expectException(NonVirtualPropertyException::class);
        $this->pd->getVirtualGetter(self::RP_NAME);
    }

    public function testRealPropertyException3()
    {
        $this->expectException(UnavailableOperationException::class);
        $this->pd->getGetterHooks(self::RP_NAME);
    }

    public function testRealPropertyException4()
    {
        $this->expectException(NonVirtualPropertyException::class);
        $this->pd->getVirtualSetter(self::RP_NAME);
    }

    public function testRealPropertyException5()
    {
        $this->expectException(InvalidPropertyException::class);
        $this->pd->newProperty('invalidProperty', false, false);
    }

    public function testRealPropertyException6()
    {
        $this->expectException(DuplicatePropertyException::class);
        $this->pd->newProperty(self::RP_NAME, true, false);
    }

    public function testVirtualProperty()
    {
        $name = self::VP_NAME;

        $this->assertTrue($this->pd->propertyExists($name));
        $this->assertTrue($this->pd->isVirtual($name));
        $this->assertFalse($this->pd->setterAvailable($name));
        $this->assertTrue($this->pd->getterAvailable($name));
        $this->assertEquals([], $this->pd->getGetterHooks($name));

        $this->assertEquals(33 - 4, $this->pd->getVirtualGetter(self::VP_NAME)());

        $cls1 = function () {
            return 33;
        };
        $cls2 = function () {
            return 4;
        };

        $this->pd->addGetterHook($name, $cls1);
        $this->pd->addGetterHook($name, $cls2);

        $hooks = $this->pd->getGetterHooks($name);
        $this->assertEquals(33, $hooks[0]());
        $this->assertEquals(4, $hooks[1]());
    }

    public function testVirtualPropertyException1()
    {
        $this->expectException(UnavailableOperationException::class);
        $this->pd->addSetterHook(self::VP_NAME, function () {
        });
    }

    public function testVirtualPropertyException2()
    {
        $this->expectException(UnavailableOperationException::class);
        $this->pd->getVirtualSetter(self::VP_NAME);
    }

    public function testVirtualPropertyException3()
    {
        $this->expectException(UnavailableOperationException::class);
        $this->pd->getSetterHooks(self::VP_NAME);
    }

    public function testVirtualPropertyException4()
    {
        $this->expectException(InvalidPropertyException::class);
        $this->pd->newVirtualProperty('invalidProperty', null, null);
    }

    public function testVirtualPropertyException5()
    {
        $this->expectException(DuplicatePropertyException::class);
        $this->pd->newVirtualProperty(self::VP_NAME, null, function () {
        });
    }
}