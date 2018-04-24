<?php

namespace Strict\Property\Tests\Utility;

use Strict\Property\Utility\AutoPropertyRequire;


/**
 * @property int $value1
 * @property-read int $value2
 * @property-write int $value3
 */
trait ZZAutoPropertyTraitMock
{
    use AutoPropertyRequire;

    public function getValue1(): int
    {
        return 3;
    }

    protected function setValue1(int $value): void
    {

    }

    private function getValue2(): int
    {
        return 4;
    }

    protected function setValue3(int $value): void
    {

    }
}