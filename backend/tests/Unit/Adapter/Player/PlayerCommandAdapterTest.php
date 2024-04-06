<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\Player;

use App\Adapter\Player\PlayerCommandAdapter;
use App\Eloquents\EloquentPlayer;
use App\Eloquents\EloquentSportCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use Tests\TestCase;

class PlayerCommandAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function testUpsertPlayers(): void
    {
        $playerAdapterCommand = new PlayerCommandAdapter(new EloquentPlayer());
        $sportCategory = EloquentSportCategory::factory()->create();

        $player1 = TennisPlayer::fromArray(['id' => 'test1', 'sport_category_id' => $sportCategory->id]);
        $player2 = TennisPlayer::fromArray(['id' => 'test2', 'sport_category_id' => $sportCategory->id]);
        $player3 = TennisPlayer::fromArray(['id' => 'test3', 'sport_category_id' => $sportCategory->id]);
        $players = TennisPlayers::fromArray([$player1, $player2, $player3]);

        $playerAdapterCommand->upsertByKeys($players, ['id']);

        $this->assertDatabaseCount('players', 3);
        $this->assertDatabaseHas('players', ['id' => 'test1']);
        $this->assertDatabaseHas('players', ['id' => 'test2']);
        $this->assertDatabaseHas('players', ['id' => 'test3']);
    }
}
