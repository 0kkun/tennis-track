<?php

namespace Tests\Packages\FavoritePlayer\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\FavoritePlayer\Domain\Models\FavoritePlayer;
use TennisTrack\FavoritePlayer\Domain\Models\FavoritePlayers;

class FavoritePlayersTest extends TestCase
{
    public function testCanCreatedWithPlayersArray(): void
    {
        $player1 = FavoritePlayer::fromArray(['id' => 1]);
        $player2 = FavoritePlayer::fromArray(['id' => 2]);
        $player3 = FavoritePlayer::fromArray(['id' => 3]);

        $players = FavoritePlayers::fromArray([$player1, $player2, $player3]);

        $this->assertInstanceOf(FavoritePlayers::class, $players);
    }

    public function testCanGetPlayersArray(): void
    {
        $player1 = FavoritePlayer::fromArray(['id' => 1]);
        $player2 = FavoritePlayer::fromArray(['id' => 2]);
        $player3 = FavoritePlayer::fromArray(['id' => 3]);

        $players = FavoritePlayers::fromArray([$player1, $player2, $player3]);

        $this->assertEquals([
            $player1->toArray(),
            $player2->toArray(),
            $player3->toArray(),
        ], $players->toArray());
    }

    public function testCount()
    {
        $player1 = FavoritePlayer::fromArray(['id' => 1]);
        $player2 = FavoritePlayer::fromArray(['id' => 2]);
        $player3 = FavoritePlayer::fromArray(['id' => 3]);

        $players = FavoritePlayers::fromArray([$player1, $player2, $player3]);

        $this->assertEquals(3, $players->count());
    }

    public function testAdd()
    {
        $player1 = FavoritePlayer::fromArray(['id' => 1]);
        $player2 = FavoritePlayer::fromArray(['id' => 2]);
        $player3 = FavoritePlayer::fromArray(['id' => 3]);

        $players = FavoritePlayers::fromArray([$player1, $player2]);

        $players->add($player3);

        $this->assertEquals([
            $player1->toArray(),
            $player2->toArray(),
            $player3->toArray(),
        ], $players->toArray());
    }
}
