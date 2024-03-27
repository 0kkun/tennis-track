<?php

declare(strict_types=1);

namespace Tests\Packages\Player\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\Player\Domain\Models\Player;
use TennisTrack\Player\Domain\Models\Players;

class PlayersTest extends TestCase
{
    public function testCanCreatedWithPlayersArray(): void
    {
        $player1 = Player::fromArray(['id' => 'test1']);
        $player2 = Player::fromArray(['id' => 'test2']);
        $player3 = Player::fromArray(['id' => 'test3']);

        $players = Players::fromArray([$player1, $player2, $player3]);

        $this->assertInstanceOf(Players::class, $players);
    }

    public function testThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Players::fromArray(['invalid', 'player']);
    }

    public function testCanAddPlayer(): void
    {
        $players = Players::fromArray([]);
        $player = Player::fromArray(['id' => 'test1']);

        $players->addPlayer($player);

        $this->assertCount(1, $players->getPlayers());
        $this->assertContains($player, $players->getPlayers());
    }

    public function testCanReturnPlayersArray(): void
    {
        $player1 = Player::fromArray(['id' => 'test1']);
        $player2 = Player::fromArray(['id' => 'test2']);

        $players = Players::fromArray([$player1, $player2]);

        $this->assertIsArray($players->getPlayers());
        $this->assertCount(2, $players->getPlayers());
    }

    public function testCanCreatedFromArray(): void
    {
        $player1 = Player::fromArray(['id' => 'test1']);
        $player2 = Player::fromArray(['id' => 'test2']);

        $players = Players::fromArray([$player1, $player2]);

        $this->assertInstanceOf(Players::class, $players);
        $this->assertCount(2, $players->getPlayers());
    }

    public function testCanIterated(): void
    {
        $player1 = Player::fromArray(['id' => 'test1']);
        $player2 = Player::fromArray(['id' => 'test2']);
        $player3 = Player::fromArray(['id' => 'test3']);

        $players = Players::fromArray([$player1, $player2, $player3]);

        $result = [];
        foreach ($players as $player) {
            $result[] = $player;
        }

        $this->assertCount(3, $result);
        $this->assertContains($player1, $result);
        $this->assertContains($player2, $result);
        $this->assertContains($player3, $result);
    }
}
