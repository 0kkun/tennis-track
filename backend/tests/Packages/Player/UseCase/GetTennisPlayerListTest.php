<?php

declare(strict_types=1);

namespace Tests\Packages\Player\UseCase;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\UseCase\GetTennisPlayerList;
use TennisTrack\Player\UseCase\Ports\PlayerQueryPort;
use TennisTrack\SportCategory\Domain\Models\SportCategory;
use TennisTrack\SportCategory\Domain\Models\Name;
use TennisTrack\SportCategory\Domain\Models\Id;
use TennisTrack\SportCategory\UseCase\Ports\SportCategoryQueryPort;

class GetTennisPlayerListTest extends TestCase
{
    public function testExecute(): void
    {
        $sportCategoryQueryMock = $this->createMock(SportCategoryQueryPort::class);
        $sportCategoryQueryMock
            ->expects($this->once())
            ->method('getByName')
            ->with($this->equalTo(Name::asTennis()->toString()))
            ->willReturn(SportCategory::fromArray(['id' => 1, 'name' => Name::asTennis()->toString()]));

        $playerAdapterCommandMock = $this->createMock(PlayerQueryPort::class);
        $playerAdapterCommandMock
            ->expects($this->once())
            ->method('fetchBySportCategoryId')
            ->with($this->equalTo(Id::from(1)))
            ->willReturn([]);

        $getTennisPlayer = new GetTennisPlayerList($playerAdapterCommandMock, $sportCategoryQueryMock);

        $getTennisPlayer->execute();
    }
}
