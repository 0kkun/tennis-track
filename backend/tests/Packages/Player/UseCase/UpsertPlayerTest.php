<?php

declare(strict_types=1);

namespace Tests\Packages\Player\UseCase;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;
use TennisTrack\Player\UseCase\UpsertPlayer;

class UpsertPlayerTest extends TestCase
{
    public function testExecute(): void
    {
        $playerAdapterCommandMock = $this->createMock(PlayerAdapterCommandPort::class);
        $playerAdapterCommandMock->expects($this->once())
            ->method('upsertById')
            ->with($this->isInstanceOf(TennisPlayers::class));

        $upsertPlayer = new UpsertPlayer($playerAdapterCommandMock);

        $player1 = TennisPlayer::fromArray(['id' => 'test1']);
        $player2 = TennisPlayer::fromArray(['id' => 'test2']);
        $player3 = TennisPlayer::fromArray(['id' => 'test3']);
        $players = TennisPlayers::fromArray([$player1, $player2, $player3]);

        $upsertPlayer->execute($players);
    }
}
