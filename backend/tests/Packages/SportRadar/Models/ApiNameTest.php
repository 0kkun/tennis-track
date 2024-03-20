<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\SportRadar\Domain\Models\ApiName;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ApiNameTest extends TestCase
{
    public function testApiNameValid()
    {
        $apiName = new ApiName('player_profile');
        $this->assertEquals('player_profile', $apiName->toString());
    }

    public function testApiNameInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        new ApiName('invalid');
    }

    public function testPlayerProfile()
    {
        $apiName = ApiName::playerProfile();
        $this->assertEquals('player_profile', $apiName->toString());
    }

    public function testPlayerRankings()
    {
        $apiName = ApiName::playerRankings();
        $this->assertEquals('player_rankings', $apiName->toString());
    }

    public function testPlayerRaceRankings()
    {
        $apiName = ApiName::playerRaceRankings();
        $this->assertEquals('player_race_rankings', $apiName->toString());
    }

    public function testPlayerHeadToHead()
    {
        $apiName = ApiName::playerHeadToHead();
        $this->assertEquals('player_head_to_head', $apiName->toString());
    }
}
