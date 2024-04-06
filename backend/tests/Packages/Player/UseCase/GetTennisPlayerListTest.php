<?php

declare(strict_types=1);

namespace Tests\Packages\Player\UseCase;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\UseCase\GetTennisPlayerList;
use TennisTrack\Player\UseCase\Ports\PlayerQueryPort;

class GetTennisPlayerListTest extends TestCase
{
    public function testExecute(): void
    {
        $playerAdapterCommandMock = $this->createMock(PlayerQueryPort::class);
        $playerAdapterCommandMock
            ->expects($this->once())
            ->method('fetchBySportCategoryId')
            ->with($this->equalTo(1))
            ->willReturn([]);

        $getTennisPlayer = new GetTennisPlayerList($playerAdapterCommandMock);

        $getTennisPlayer->execute();
    }
}
