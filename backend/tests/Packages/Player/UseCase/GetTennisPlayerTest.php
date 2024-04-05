<?php

declare(strict_types=1);

namespace Tests\Packages\Player\UseCase;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\GetTennisPlayer;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;

class GetTennisPlayerTest extends TestCase
{
    public function testExecute(): void
    {
        $playerAdapterCommandMock = $this->createMock(PlayerAdapterCommandPort::class);
        $playerAdapterCommandMock->expects($this->once())
            ->method('fetchBySportCategoryId')
            ->with($this->equalTo(1))
            ->willReturn([]);

        $getTennisPlayer = new GetTennisPlayer($playerAdapterCommandMock);

        $players = $getTennisPlayer->execute();

        $this->assertInstanceOf(TennisPlayers::class, $players);
    }
}
