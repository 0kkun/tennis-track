<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\SportRadar\Domain\Models\LanguageCode;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LanguageCodeTest extends TestCase
{
    public function testLanguageCode()
    {
        $languageCode = new LanguageCode('en');
        $this->assertEquals('en', $languageCode->toString());
    }

    public function testLanguageCodeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        new LanguageCode('invalid');
    }

    public function testLanguageCodeEn()
    {
        $languageCode = LanguageCode::en();
        $this->assertEquals('en', $languageCode->toString());
    }

    public function testLanguageCodeJa()
    {
        $languageCode = LanguageCode::ja();
        $this->assertEquals('ja', $languageCode->toString());
    }
}