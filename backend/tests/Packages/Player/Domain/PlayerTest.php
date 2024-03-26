<?php

namespace Tests\Packages\Player\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\Domain\Models\Abbreviation;
use TennisTrack\Player\Domain\Models\Birthday;
use TennisTrack\Player\Domain\Models\Player;
use TennisTrack\Player\Domain\Models\Id;
use TennisTrack\Player\Domain\Models\NameEn;
use TennisTrack\Player\Domain\Models\NameJa;
use TennisTrack\Player\Domain\Models\Country;
use TennisTrack\Player\Domain\Models\CountryCode;
use TennisTrack\Player\Domain\Models\Gender;
use TennisTrack\Player\Domain\Models\Handedness;
use TennisTrack\Player\Domain\Models\Height;
use TennisTrack\Player\Domain\Models\HighestDoublesRanking;
use TennisTrack\Player\Domain\Models\HighestSinglesRanking;
use TennisTrack\Player\Domain\Models\ProYear;
use TennisTrack\Player\Domain\Models\Weight;

class PlayerTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testFromArray()
    {
        Player::fromArray([
            'id' => 'test',
        ]);
    }

    public function testToArray()
    {
        $player = Player::fromArray([
            'id' => 'test',
        ]);

        $this->assertEquals('test', $player->toArray()['id']);
    }

    public function testId()
    {
        $player = Player::fromArray([
            'id' => 'test',
        ]);
        $this->assertInstanceOf(Id::class, $player->id());
        $this->assertEquals('test', $player->id()->toString());
    }

    public function testNameJa()
    {
        $player = Player::fromArray([
            'name_ja' => 'test',
        ]);
        $this->assertInstanceOf(NameJa::class, $player->nameJa());
        $this->assertEquals('test', $player->nameJa()->toString());
    }

    public function testNameEn()
    {
        $player = Player::fromArray([
            'name_en' => 'test',
        ]);
        $this->assertInstanceOf(NameEn::class, $player->nameEn());
        $this->assertEquals('test', $player->nameEn()->toString());
    }

    public function testCountry()
    {
        $player = Player::fromArray([
            'country' => 'test',
        ]);
        $this->assertInstanceOf(Country::class, $player->country());
        $this->assertEquals('test', $player->country()->toString());
    }

    public function testCountryCode()
    {
        $player = Player::fromArray([
            'country_code' => 'test',
        ]);
        $this->assertInstanceOf(CountryCode::class, $player->countryCode());
        $this->assertEquals('test', $player->countryCode()->toString());
    }

    public function testGender()
    {
        $player = Player::fromArray([
            'gender' => 'male',
        ]);
        $this->assertInstanceOf(Gender::class, $player->gender());
        $this->assertEquals('male', $player->gender()->toString());
    }

    public function testBirthday()
    {
        $player = Player::fromArray([
            'birthday' => '2020-01-01',
        ]);
        $this->assertInstanceOf(Birthday::class, $player->birthday());
    }

    public function testAbbreviation()
    {
        $player = Player::fromArray([
            'abbreviation' => 'test',
        ]);
        $this->assertInstanceOf(Abbreviation::class, $player->abbreviation());
        $this->assertEquals('test', $player->abbreviation()->toString());
    }

    public function testProYear()
    {
        $player = Player::fromArray([
            'pro_year' => 2020,
        ]);
        $this->assertInstanceOf(ProYear::class, $player->proYear());
        $this->assertEquals(2020, $player->proYear()->toInt());
    }

    public function testHandedness()
    {
        $player = Player::fromArray([
            'handedness' => 'right',
        ]);
        $this->assertInstanceOf(Handedness::class, $player->handedness());
        $this->assertEquals('right', $player->handedness()->toString());
    }

    public function testHeight()
    {
        $player = Player::fromArray([
            'height' => 180,
        ]);
        $this->assertInstanceOf(Height::class, $player->height());
        $this->assertEquals(180, $player->height()->toInt());
    }

    public function testWeight()
    {
        $player = Player::fromArray([
            'weight' => 70,
        ]);
        $this->assertInstanceOf(Weight::class, $player->weight());
        $this->assertEquals(70, $player->weight()->toInt());
    }

    public function testHighestSinglesRanking()
    {
        $player = Player::fromArray([
            'highest_singles_ranking' => 1,
        ]);
        $this->assertInstanceOf(HighestSinglesRanking::class, $player->highestSinglesRanking());
        $this->assertEquals(1, $player->highestSinglesRanking()->toInt());
    }

    public function testHighestDoublesRanking()
    {
        $player = Player::fromArray([
            'highest_doubles_ranking' => 1,
        ]);
        $this->assertInstanceOf(HighestDoublesRanking::class, $player->highestDoublesRanking());
        $this->assertEquals(1, $player->highestDoublesRanking()->toInt());
    }
}
