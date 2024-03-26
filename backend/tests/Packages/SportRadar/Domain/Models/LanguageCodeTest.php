<?php

namespace Tests\Packages\SportRadar\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\SportRadar\Domain\Models\LanguageCode;

class LanguageCodeTest extends TestCase
{
    public function testLanguageCode()
    {
        $languageCode = LanguageCode::from('en');
        $this->assertEquals('en', $languageCode->toString());
    }

    public function testLanguageCodeInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        LanguageCode::from('invalid');
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
