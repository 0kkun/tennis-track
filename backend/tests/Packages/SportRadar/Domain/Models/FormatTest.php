<?php

namespace Tests\Packages\SportRadar\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\SportRadar\Domain\Models\Format;

class FormatTest extends TestCase
{
    public function testFormat()
    {
        $format = Format::from('json');
        $this->assertEquals('json', $format->toString());
    }

    public function testFormatInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        Format::from('invalid');
    }

    public function testFormatJson()
    {
        $format = Format::json();
        $this->assertEquals('json', $format->toString());
    }

    public function testFormatXml()
    {
        $format = Format::xml();
        $this->assertEquals('xml', $format->toString());
    }
}
