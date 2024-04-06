<?php

declare(strict_types=1);

namespace TennisTrack\Ranking\Domain\Models;

use Carbon\Carbon;
use TennisTrack\Player\Domain\Models\Id as PlayerId;

final class TennisRanking
{
    /**
     * @param Id $id
     * @param PlayerId $playerId
     * @param Type $type
     * @param Rank $rank
     * @param Movement $movement
     * @param PlayedCount $playedCount
     * @param Point $point
     * @param RankingDate $rankingDate
     */
    public function __construct(
        private Id $id,
        private PlayerId $playerId,
        private Type $type,
        private Rank $rank,
        private Movement $movement,
        private PlayedCount $playedCount,
        private Point $point,
        private RankingDate $rankingDate
    ) {
        $this->id = $id;
        $this->playerId = $playerId;
        $this->type = $type;
        $this->rank = $rank;
        $this->movement = $movement;
        $this->playedCount = $playedCount;
        $this->point = $point;
        $this->rankingDate = $rankingDate;
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @return PlayerId
     */
    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    /**
     * @return Type
     */
    public function type(): Type
    {
        return $this->type;
    }

    /**
     * @return Rank
     */
    public function rank(): Rank
    {
        return $this->rank;
    }

    /**
     * @return Movement
     */
    public function movement(): Movement
    {
        return $this->movement;
    }

    /**
     * @return PlayedCount
     */
    public function playedCount(): PlayedCount
    {
        return $this->playedCount;
    }

    /**
     * @return Point
     */
    public function point(): Point
    {
        return $this->point;
    }

    /**
     * @return RankingDate
     */
    public function rankingDate(): RankingDate
    {
        return $this->rankingDate;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Id::from($data['id'] ?? 0),
            PlayerId::from($data['player_id'] ?? ''),
            Type::from($data['type'] ?? ''),
            Rank::from($data['rank'] ?? 0),
            Movement::from($data['movement'] ?? 0),
            PlayedCount::from($data['played_count'] ?? 0),
            Point::from($data['point'] ?? 0),
            RankingDate::from($data['ranking_date'] ?? Carbon::now())
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toInt(),
            'player_id' => $this->playerId->toString(),
            'type' => $this->type->toString(),
            'rank' => $this->rank->toInt(),
            'movement' => $this->movement->toInt(),
            'played_count' => $this->playedCount->toInt(),
            'point' => $this->point->toInt(),
            'ranking_date' => $this->rankingDate->get(),
        ];
    }
}
