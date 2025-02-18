<?php

declare(strict_types=1);

namespace TennisTrack\FavoritePlayer\Domain\Models;

use TennisTrack\Player\Domain\Models\Id as PlayerId;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\User\Domain\Models\Id as UserId;

final class FavoritePlayer
{
    /**
     * @param Id $id
     * @param UserId $userId
     * @param PlayerId $playerId
     * @param TennisPlayer $player
     */
    private function __construct(
        private Id $id,
        private UserId $userId,
        private PlayerId $playerId,
        private TennisPlayer $tennisPlayer
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->playerId = $playerId;
        $this->tennisPlayer = $tennisPlayer;
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return PlayerId
     */
    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    /**
     * @return TennisPlayer
     */
    public function tennisPlayer(): TennisPlayer
    {
        return $this->tennisPlayer;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Id::from($data['id'] ?? 0),
            UserId::from($data['user_id'] ?? 0),
            PlayerId::from($data['player_id'] ?? ''),
            TennisPlayer::fromArray($data['player'] ?? [])
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toInt(),
            'user_id' => $this->userId->toInt(),
            'player_id' => $this->playerId->toString(),
            'player' => $this->tennisPlayer->toArray(),
        ];
    }
}
