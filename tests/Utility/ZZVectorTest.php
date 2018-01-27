<?php

namespace Strict\Property\Tests\Utility;

use PHPUnit\Framework\TestCase;


class ZZVectorTest
    extends TestCase
{
    public function testBehavior() {
        $vec = new ZZVector(0, 4);
        $this->assertTrue( 3.99 <= $vec->r && $vec->r <= 4.01 );

        $vec->x = 3;
        $this->assertTrue( 4.99 <= $vec->r && $vec->r <= 5.01 );

        // $vec->x = '3.00';   // TypeError
        $nv = clone $vec;
        $nv->x = 5;
        $this->assertTrue( 4.99 <= $vec->r && $vec->r <= 5.01 );
    }
}