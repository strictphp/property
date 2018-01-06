<?php

namespace Strict\Property\Tests\Utility;

use Strict\Property\Utility\ReadonlyPropertyContainer;


/**
 *
 * @property-read int $intValue
 * @property-read \stdClass $stdClass
 */
class TXContainerMock extends ReadonlyPropertyContainer
{

    public function __construct()
    {
        $this->setReadonlyProperty('intValue', 33 - 4);
        $this->setReadonlyProperty('stdClass', [new \stdClass(['this' => 'is'])]);
    }

    public function getA(): array
    {
        return $this->getReadonlyPropertyAll();
    }

}
