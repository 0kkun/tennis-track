<?php

namespace Tests\Packages\SportRadar\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\SportRadar\Domain\Models\AccessLevel;

class AccessLevelTest extends TestCase
{
    public function testAccessLevelTrial()
    {
        $accessLevel = AccessLevel::trial();
        $this->assertEquals('trial', $accessLevel->toString());
    }

    public function testAccessLevelProduction()
    {
        $accessLevel = AccessLevel::production();
        $this->assertEquals('production', $accessLevel->toString());
    }

    public function testAccessLevelInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        AccessLevel::from('invalid');
    }
}
