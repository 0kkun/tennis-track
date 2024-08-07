<?php

declare(strict_types=1);

namespace TennisTrack\Player\Domain\Models;

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
     * @return int
     */
    public function count(): int
    {
        return count($this->players);
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
        $items = [];
        foreach ($players as $player) {
            if (is_array($player)) {
                $items[] = TennisPlayer::fromArray($player);
            } elseif ($player instanceof TennisPlayer) {
                $items[] = $player;
            } else {
                continue; // 無効なエントリをスキップ
            }
        }

        return new self($items);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(fn (TennisPlayer $player) => $player->toArray(), $this->players);
    }

    /**
     * @return bool
     */
    public function empty(): bool
    {
        return empty($this->players);
    }
}
