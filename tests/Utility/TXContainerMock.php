<?php

namespace Strict\Property\Tests\Utility;

use Strict\Property\Utility\ReadonlyPropertyContainer;


/**
 * 
 * @property-read int $intValue
 */
class TXContainerMock extends ReadonlyPropertyContainer
{

    public function __construct()
    {
        $this->setReadonlyProperty('intValue', 33 - 4);
    }

    public function getA(): array
    {
        return $this->getReadonlyPropertyAll();
    }

}
