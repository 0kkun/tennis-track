<?php

declare(strict_types=1);

namespace Tests\Packages\Ranking\UseCase;

use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingQueryPort;
use TennisTrack\Ranking\UseCase\GetTennisRankings;
use PHPUnit\Framework\TestCase;

class GetTennisRankingsTest extends TestCase
{
    public function testExecute(): void
    {
        $tennisRankingQueryMock = $this->createMock(TennisRankingQueryPort::class);
        $tennisRankingQueryMock
            ->expects($this->once())
            ->method('fetchForLatest')
            ->willReturn(TennisRankings::fromArray([]));
        $useCase = new GetTennisRankings($tennisRankingQueryMock);

        $result = $useCase->execute();
        $this->assertInstanceOf(TennisRankings::class, $result);
    }
}
