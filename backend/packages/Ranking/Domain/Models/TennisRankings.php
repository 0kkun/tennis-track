<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\Domain\Models;

use TennisTrack\Common\Exceptions\InvalidArgumentException;

final class TennisRankings implements \IteratorAggregate
{
    /**
     * @param TennisRanking[] $rankings
     */
    private function __construct(private array $rankings)
    {
        $this->setRankings($rankings);
    }

    /**
     * @param array<TennisRanking> $rankings
     * @throws InvalidArgumentException
     */
    private function setRankings(array $rankings): void
    {
        foreach ($rankings as $ranking) {
            if (! $ranking instanceof TennisRanking) {
                throw new InvalidArgumentException('Invalid ranking provided.');
            }
        }
        $this->rankings = $rankings;
    }

    /**
     * @param TennisRanking $ranking
     * @return void
     */
    public function addRanking(TennisRanking $ranking): void
    {
        $this->rankings[] = $ranking;
    }

    /**
     * @return TennisRanking[]
     */
    public function getRankings(): array
    {
        return $this->rankings;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->rankings);
    }

    /**
     * @param array $rankings
     * @return self
     */
    public static function fromArray(array $rankings): self
    {
        return new self($rankings);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(fn (TennisRanking $ranking) => $ranking->toArray(), $this->rankings);
    }
}
