<?php

declare(strict_types=1);

namespace Tests\Packages\Player\UseCase;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\Domain\Models\Player;
use TennisTrack\Player\Domain\Models\Players;
use TennisTrack\Player\UseCase\Ports\PlayerAdapterCommandPort;
use TennisTrack\Player\UseCase\UpsertPlayer;

class UpsertPlayerTest extends TestCase
{
    public function testExecute(): void
    {
        $playerAdapterCommandMock = $this->createMock(PlayerAdapterCommandPort::class);
        $playerAdapterCommandMock->expects($this->once())
            ->method('upsertById')
            ->with($this->isInstanceOf(Players::class));

        $upsertPlayer = new UpsertPlayer($playerAdapterCommandMock);

        $player1 = Player::fromArray(['id' => 'test1']);
        $player2 = Player::fromArray(['id' => 'test2']);
        $player3 = Player::fromArray(['id' => 'test3']);
        $players = Players::fromArray([$player1, $player2, $player3]);

        $upsertPlayer->execute($players);
    }
}
