<?php

declare(strict_types=1);

namespace Tests\Packages\Player\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;

class TennisPlayersTest extends TestCase
{
    public function testCanCreatedWithPlayersArray(): void
    {
        $player1 = TennisPlayer::fromArray(['id' => 'test1']);
        $player2 = TennisPlayer::fromArray(['id' => 'test2']);
        $player3 = TennisPlayer::fromArray(['id' => 'test3']);

        $players = TennisPlayers::fromArray([$player1, $player2, $player3]);

        $this->assertInstanceOf(TennisPlayers::class, $players);
    }

    public function testCanCreatedFromArray(): void
    {
        $player1 = TennisPlayer::fromArray(['id' => 'test1']);
        $player2 = TennisPlayer::fromArray(['id' => 'test2']);

        $players = TennisPlayers::fromArray([$player1, $player2]);

        $this->assertInstanceOf(TennisPlayers::class, $players);
    }

    public function testCanIterated(): void
    {
        $player1 = TennisPlayer::fromArray(['id' => 'test1']);
        $player2 = TennisPlayer::fromArray(['id' => 'test2']);
        $player3 = TennisPlayer::fromArray(['id' => 'test3']);

        $players = TennisPlayers::fromArray([$player1, $player2, $player3]);

        $result = [];
        foreach ($players as $player) {
            $result[] = $player;
        }

        $this->assertCount(3, $result);
        $this->assertContains($player1, $result);
        $this->assertContains($player2, $result);
        $this->assertContains($player3, $result);
    }

    public function testCanCount(): void
    {
        $player1 = TennisPlayer::fromArray(['id' => 'test1']);
        $player2 = TennisPlayer::fromArray(['id' => 'test2']);
        $player3 = TennisPlayer::fromArray(['id' => 'test3']);

        $players = TennisPlayers::fromArray([$player1, $player2, $player3]);

        $this->assertSame(3, $players->count());
    }

    public function testEmpty()
    {
        $players = TennisPlayers::fromArray([]);

        $this->assertSame(0, $players->count());
    }
}
