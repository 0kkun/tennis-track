<?php

namespace Tests\Packages\FavoritePlayer\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\FavoritePlayer\Domain\Models\FavoritePlayer;

class FavoritePlayerTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testFromArray()
    {
        FavoritePlayer::fromArray([
            'id' => 1,
        ]);
    }

    public function testToArray()
    {
        $favoritePlayer = FavoritePlayer::fromArray([
            'id' => 1,
        ]);

        $this->assertEquals([
            'id' => 1,
            'user_id' => 0,
            'player_id' => '',
            'player' => [
                'id' => '',
                'name_en' => null,
                'name_ja' => null,
                'country_code' => null,
                'country' => null,
                'abbreviation' => null,
                'gender' => null,
                'birthday' => null,
                'pro_year' => null,
                'handedness' => null,
                'height' => null,
                'weight' => null,
                'highest_singles_ranking' => null,
                'highest_doubles_ranking' => null,
                'sport_category_id' => 0,
            ],
        ], $favoritePlayer->toArray());
    }

    public function testId()
    {
        $favoritePlayer = FavoritePlayer::fromArray([
            'id' => 1,
        ]);

        $this->assertEquals(1, $favoritePlayer->id()->toInt());
    }

    public function testUserId()
    {
        $favoritePlayer = FavoritePlayer::fromArray([
            'id' => 1,
            'user_id' => 1,
        ]);

        $this->assertEquals(1, $favoritePlayer->userId()->toInt());
    }

    public function testPlayerId()
    {
        $favoritePlayer = FavoritePlayer::fromArray([
            'id' => 1,
            'player_id' => 'test_player_id',
        ]);

        $this->assertEquals('test_player_id', $favoritePlayer->playerId()->toString());
    }
}
