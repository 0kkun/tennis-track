<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\SportRadar\Domain\Models\Format;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testFormat()
    {
        $format = new Format('json');
        $this->assertEquals('json', $format->toString());
    }

    public function testFormatInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        new Format('invalid');
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