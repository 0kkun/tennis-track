<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;

// NOTE: 使い方
// $players = new PlayerList([$player1, $player2, $player3]);
// foreach ($players as $player) {
//     // $player は Player オブジェクト
//     echo $player->getName();
// }

final class TennisPlayers implements \IteratorAggregate
{
    /**
     * @param TennisPlayer[] $players
     */
    private function __construct(private array $players)
    {
        $this->setPlayers($players);
    }

    /**
     * @param array<TennisPlayer> $players
     * @throws InvalidArgumentException
     */
    private function setPlayers(array $players): void
    {
        foreach ($players as $player) {
            if (! $player instanceof TennisPlayer) {
                throw new InvalidArgumentException('Invalid player provided.');
            }
        }
        $this->players = $players;
    }

    /**
     * @param TennisPlayer $player
     */
    public function addPlayer(TennisPlayer $player): void
    {
        $this->players[] = $player;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->players);
    }

    /**
     * @param array $players
     * @return self
     */
    public static function fromArray(array $players): self
    {
        return new self($players);
    }

    public function toArray(): array
    {
        return array_map(fn (TennisPlayer $player) => $player->toArray(), $this->players);
    }
}
