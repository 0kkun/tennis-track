<?php

namespace Tests\Packages\SportRadar\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\SportRadar\Domain\Models\ApiName;
use TennisTrack\SportRadar\Domain\Models\Endpoint;

class EndpointTest extends TestCase
{
    public function testPathRankings()
    {
        $apiName = ApiName::playerRankings();
        $endpoint = Endpoint::fromArray([
            'api_name' => $apiName,
        ]);
        $this->assertIsString($endpoint->path());
    }

    public function testPathProfile()
    {
        $apiName = ApiName::playerProfile();
        $endpoint = Endpoint::fromArray([
            'api_name' => $apiName,
            'player_id_main' => '1234',
        ]);
        $this->assertIsString($endpoint->path());
    }

    public function testPathRaceRankings()
    {
        $apiName = ApiName::playerRaceRankings();
        $endpoint = Endpoint::fromArray([
            'api_name' => $apiName,
        ]);
        $this->assertIsString($endpoint->path());
    }

    public function testPathHeadToHead()
    {
        $apiName = ApiName::playerHeadToHead();
        $endpoint = Endpoint::fromArray([
            'api_name' => $apiName,
            'player_id_main' => '1234',
            'player_id_sub' => '5678',
        ]);
        $this->assertIsString($endpoint->path());
    }

    public function testPathInvalidException()
    {
        $this->expectException(InvalidArgumentException::class);
        Endpoint::fromArray([
            'api_name' => 'invalid',
        ]);
    }
}
