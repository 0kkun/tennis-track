<?php

declare(strict_types=1);

namespace TennisTrack\FavoritePlayer\Domain\Models;

final class FavoritePlayers implements \IteratorAggregate
{
    private $favoritePlayers = [];

    /**
     * @param FavoritePlayer ...$favoritePlayers
     */
    public function __construct(FavoritePlayer ...$favoritePlayers)
    {
        $this->favoritePlayers = $favoritePlayers;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->favoritePlayers);
    }

    /**
     * @param FavoritePlayer $favoritePlayer
     * @return void
     */
    public function add(FavoritePlayer $favoritePlayer): void
    {
        $this->favoritePlayers[] = $favoritePlayer;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->favoritePlayers);
    }

    /**
     * @param array $favoritePlayers
     * @return self
     */
    public static function fromArray(array $favoritePlayers): self
    {
        $items = [];
        foreach ($favoritePlayers as $favoritePlayer) {
            if (is_array($favoritePlayer)) {
                $items[] = FavoritePlayer::fromArray($favoritePlayer);
            } elseif ($favoritePlayer instanceof FavoritePlayer) {
                $items[] = $favoritePlayer;
            } else {
                throw new \InvalidArgumentException('Invalid argument');
            }
        }

        return new self(...$items);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        foreach ($this->favoritePlayers as $favoritePlayer) {
            if ($favoritePlayer instanceof FavoritePlayer) {
                $items[] = $favoritePlayer->toArray();
            } elseif (is_array($favoritePlayer)) {
                $items[] = $favoritePlayer;
            } else {
                throw new \InvalidArgumentException('Invalid argument');
            }
        }

        return $items;
    }
}
