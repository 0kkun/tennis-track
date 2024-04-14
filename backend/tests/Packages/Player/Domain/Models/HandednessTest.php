<?php

namespace Tests\Packages\Player\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Player\Domain\Models\Handedness;

class HandednessTest extends TestCase
{
    public function testHandednessRight()
    {
        $handedness = Handedness::from('right');
        $this->assertTrue($handedness->isRight());
    }

    public function testHandednessLeft()
    {
        $handedness = Handedness::from('left');
        $this->assertTrue($handedness->isLeft());
    }

    public function testInvalidError()
    {
        $this->expectException(InvalidArgumentException::class);
        Handedness::from('invalid');
    }

    public function testFromInt()
    {
        $handednessRight = Handedness::fromInt(0);
        $this->assertEquals('right', $handednessRight->toString());

        $handednessLeft = Handedness::fromInt(1);
        $this->assertEquals('left', $handednessLeft->toString());
    }

    public function testToInt()
    {
        $handednessRight = Handedness::from('right');
        $this->assertEquals(0, $handednessRight->toInt());

        $handednessLeft = Handedness::from('left');
        $this->assertEquals(1, $handednessLeft->toInt());
    }
}
