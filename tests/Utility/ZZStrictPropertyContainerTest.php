<?php

namespace Strict\Property\Tests\Utility;

use PHPUnit\Framework\TestCase;


class ZZStrictPropertyContainerTest
    extends TestCase
{
    /** @var ZZStrictPropertyContainerMock */
    private $spc;

    public function setUp()
    {
        $this->spc = new ZZStrictPropertyContainerMock;
    }

    public function testRealProperty()
    {
        $this->assertEquals(33.4, $this->spc->realProperty);
        $newSPC = clone $this->spc;
        $newSPC->realProperty = 44.3;
        $this->assertEquals(33.4, $this->spc->realProperty);
        $this->assertEquals(44.3, $newSPC->realProperty);

    }

    public function testVirtualProperty()
    {
        $this->assertEquals(3, $this->spc->virtualProperty);
        $this->spc->changeValue(4);
        $this->assertEquals(4, $this->spc->virtualProperty);
        $newSPC = clone $this->spc;
        $newSPC->changeValue(5);
        $this->assertEquals(4, $this->spc->virtualProperty);
        $this->assertEquals(5, $newSPC->virtualProperty);
    }
}