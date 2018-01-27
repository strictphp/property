<?php

namespace Strict\Property\Tests\Intermediate;

use PHPUnit\Framework\TestCase;
use Strict\Property\Intermediate\PropertyDefinition;
use Strict\Property\Intermediate\PropertyStorage;
use Closure;


class ZZPropertyStorageTest
    extends TestCase
{
    /** @var PropertyStorage */
    private $propertyStorage;

    public function setUp()
    {
        $virtualClass = new ZZVirtualPropertyClassMock;
        $propertyDefinition = new PropertyDefinition;

        $propertyDefinition->newProperty('realProperty', true, true);
        $propertyDefinition->addSetterHook('realProperty', function ($value, Closure $next) {
            $next($value * 2);
        });
        $propertyDefinition->addSetterHook('realProperty', function ($value, Closure $next) {
            $next($value + 10);
        });
        $propertyDefinition->addGetterHook('realProperty', $virtualClass->getGetterHook());
        $propertyDefinition->addGetterHook('realProperty', function (Closure $next) {
            return $next() + 10;
        });

        $propertyDefinition->newVirtualProperty('virtualProperty', $virtualClass->getGetter(), null);

        $this->propertyStorage = new PropertyStorage($propertyDefinition, $virtualClass);
    }

    public function testBehavior()
    {
        $this->assertEquals(3, $this->propertyStorage->callGetter('virtualProperty'));

        $this->propertyStorage->callSetter('realProperty', 3);
        $this->assertEquals(26, $this->propertyStorage->getPropertyDirectly('realProperty'));


        $this->propertyStorage->callSetter('realProperty', 4);
        $this->assertEquals((4 + 10) * 2 * 3 + 10, $this->propertyStorage->callGetter('realProperty'));

        $this->propertyStorage->setPropertyDirectly('realProperty', 100);
        $this->assertEquals(100 * 3 + 10, $this->propertyStorage->callGetter('realProperty'));
    }
}