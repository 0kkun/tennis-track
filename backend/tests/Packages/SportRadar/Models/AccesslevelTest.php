<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\SportRadar\Domain\Models\AccessLevel;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
        new AccessLevel('invalid');
    }
}
