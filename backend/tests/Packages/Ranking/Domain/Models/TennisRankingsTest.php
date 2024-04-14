<?php

declare(strict_types=1);

namespace Tests\Packages\Ranking\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Ranking\Domain\Models\TennisRanking;
use TennisTrack\Ranking\Domain\Models\TennisRankings;

class TennisRankingsTest extends TestCase
{
    public function testCanCreatedWithRankingsArray(): void
    {
        $ranking1 = TennisRanking::fromArray(['rank' => 1]);
        $ranking2 = TennisRanking::fromArray(['rank' => 2]);
        $ranking3 = TennisRanking::fromArray(['rank' => 3]);

        $rankings = TennisRankings::fromArray([$ranking1, $ranking2, $ranking3]);

        $this->assertInstanceOf(TennisRankings::class, $rankings);
    }

    public function testCanCreatedFromArray(): void
    {
        $ranking1 = TennisRanking::fromArray(['rank' => 1]);
        $ranking2 = TennisRanking::fromArray(['rank' => 2]);

        $rankings = TennisRankings::fromArray([$ranking1, $ranking2]);

        $this->assertInstanceOf(TennisRankings::class, $rankings);
    }

    public function testCanIterated(): void
    {
        $ranking1 = TennisRanking::fromArray(['rank' => 1]);
        $ranking2 = TennisRanking::fromArray(['rank' => 2]);
        $ranking3 = TennisRanking::fromArray(['rank' => 3]);

        $rankings = TennisRankings::fromArray([$ranking1, $ranking2, $ranking3]);

        $result = [];
        foreach ($rankings as $ranking) {
            $result[] = $ranking;
        }

        $this->assertCount(3, $result);
        $this->assertContains($ranking1, $result);
        $this->assertContains($ranking2, $result);
        $this->assertContains($ranking3, $result);
    }

    public function testCanCount(): void
    {
        $ranking1 = TennisRanking::fromArray(['rank' => 1]);
        $ranking2 = TennisRanking::fromArray(['rank' => 2]);
        $ranking3 = TennisRanking::fromArray(['rank' => 3]);

        $rankings = TennisRankings::fromArray([$ranking1, $ranking2, $ranking3]);

        $this->assertEquals(3, $rankings->count());
    }
}
