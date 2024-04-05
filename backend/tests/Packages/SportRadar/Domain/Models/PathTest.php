<?php

namespace Tests\Packages\SportRadar\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\SportRadar\Domain\Models\Path;

class PathTest extends TestCase
{
    public function testPathFrom()
    {
        $path = Path::from('/path');
        $this->assertEquals('/path', $path->toString());
    }
}
