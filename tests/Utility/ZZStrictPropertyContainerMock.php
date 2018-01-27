<?php

namespace Strict\Property\Tests\Utility;

use Strict\Property\Intermediate\PropertyRegister;
use Strict\Property\Utility\StrictPropertyContainer;


/**
 * @property $realProperty
 * @property-read $virtualProperty
 */
class ZZStrictPropertyContainerMock
    extends StrictPropertyContainer
{
    public function __construct()
    {
        parent::__construct();
        $this->realProperty = 33.4;
    }

    protected function registerProperty(PropertyRegister $propertyRegister): void
    {
        $propertyRegister
            ->newProperty('realProperty', true, true)
            ->newVirtualProperty('virtualProperty', function() {
                return $this->x;
            }, null);
    }

    private $x = 3;
    public function changeValue($x) {
        $this->x = $x;
    }
}