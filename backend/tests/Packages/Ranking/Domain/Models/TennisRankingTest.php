<?php

declare(strict_types=1);

namespace Tests\Packages\Ranking\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Ranking\Domain\Models\TennisRanking;

class TennisRankingTest extends TestCase
{
    private $testRanking;

    protected function setUp(): void
    {
        $this->testRanking = TennisRanking::fromArray([
            'rank' => 1,
            'player_id' => 'test',
            'type' => 'singles',
            'point' => 1000,
            'ranking_date' => '2021-01-01',
        ]);
    }

    public function testCanCreatedWithRankingArray(): void
    {
        $this->assertInstanceOf(TennisRanking::class, $this->testRanking);
    }

    public function testRank(): void
    {
        $this->assertEquals(1, $this->testRanking->rank()->toInt());
    }

    public function testPlayerId(): void
    {
        $this->assertEquals('test', $this->testRanking->playerId()->toString());
    }

    public function testType(): void
    {
        $this->assertEquals('singles', $this->testRanking->type()->toString());
    }

    public function testPoints(): void
    {
        $this->assertEquals(1000, $this->testRanking->point()->toInt());
    }

    public function testRankingDate(): void
    {
        $this->assertEquals('2021-01-01', $this->testRanking->rankingDate()->toDateString());
    }
}
