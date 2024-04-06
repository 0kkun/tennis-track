<?php

declare(strict_types=1);

namespace Tests\Packages\Ranking\UseCase;

use PHPUnit\Framework\TestCase;
use TennisTrack\Ranking\Domain\Models\TennisRanking;
use TennisTrack\Ranking\Domain\Models\TennisRankings;
use TennisTrack\Ranking\UseCase\Ports\TennisRankingCommandPort;
use TennisTrack\Ranking\UseCase\UpsertTennisRanking;

class UpsertTennisRankingTest extends TestCase
{
    public function testExecute(): void
    {
        $tennisRankingCommandMock = $this->createMock(TennisRankingCommandPort::class);
        $tennisRankingCommandMock
            ->expects($this->once())
            ->method('upsert')
            ->with($this->isInstanceOf(TennisRankings::class));
        $useCase = new UpsertTennisRanking($tennisRankingCommandMock);

        $ranking1 = TennisRanking::fromArray(['id' => 1]);
        $ranking2 = TennisRanking::fromArray(['id' => 2]);
        $rankings = TennisRankings::fromArray([$ranking1, $ranking2]);

        $useCase->execute($rankings);
    }
}
