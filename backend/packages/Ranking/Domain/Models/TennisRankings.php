<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\Domain\Models;

final class TennisRankings implements \IteratorAggregate
{
    /**
     * @param TennisRanking[] $rankings
     */
    private function __construct(private array $rankings)
    {
        $this->rankings = $rankings;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->rankings);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->rankings);
    }

    /**
     * @param array $rankings
     * @return self
     */
    public static function fromArray(array $rankings): self
    {
        foreach ($rankings as $ranking) {
            if (is_array($ranking)) {
                $items[] = TennisRanking::fromArray($ranking);
            }
            if ($ranking instanceof TennisRanking) {
                $items[] = $ranking;
            }
        }

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
