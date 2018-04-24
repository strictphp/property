<?php

namespace Strict\Property\Tests\Utility;

use Strict\Property\Utility\AutoProperty;


/**
 * @property int $value4
 */
class ZZAutoPropertyMock
{
    use ZZAutoPropertyTraitMock;
    use AutoProperty;

    /** @var int */
    private $value4 = 0;

    private function getValue4(): int
    {
        return $this->value4;
    }

    private function setValue4(int $value): void
    {
        $this->value4 = $value;
    }
}