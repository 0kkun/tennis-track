<?php

namespace Tests\Packages\Player\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Player\Domain\Models\Gender;

class GenderTest extends TestCase
{
    public function testGenderMale()
    {
        $gender = Gender::from('male');
        $this->assertTrue($gender->isMale());
    }

    public function testGenderFemale()
    {
        $gender = Gender::from('female');
        $this->assertTrue($gender->isFemale());
    }

    public function testInvalidError()
    {
        $this->expectException(InvalidArgumentException::class);
        Gender::from('invalid');
    }

    public function testFromInt()
    {
        $genderMale = Gender::fromInt(0);
        $this->assertEquals('male', $genderMale->toString());

        $genderFemale = Gender::fromInt(1);
        $this->assertEquals('female', $genderFemale->toString());
    }
}
