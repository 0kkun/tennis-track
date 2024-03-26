<?php

namespace Tests\Packages\SportRadar\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\SportRadar\Domain\Models\Version;

class VersionTest extends TestCase
{
    public function testVersion()
    {
        $version = Version::from('v1');
        $this->assertEquals('v1', $version->toString());
    }

    public function testVersionInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        Version::from('invalid');
    }

    public function testVersionV1()
    {
        $version = Version::v1();
        $this->assertEquals('v1', $version->toString());
    }

    public function testVersionV2()
    {
        $version = Version::v2();
        $this->assertEquals('v2', $version->toString());
    }

    public function testVersionV3()
    {
        $version = Version::v3();
        $this->assertEquals('v3', $version->toString());
    }
}
