<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\Player;

use App\Adapter\Player\PlayerAdapterCommand;
use App\Eloquents\EloquentSportCategory;
use App\Eloquents\EloquentTennisPlayer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TennisTrack\Player\Domain\Models\TennisPlayer;
use TennisTrack\Player\Domain\Models\TennisPlayers;
use Tests\TestCase;

class PlayerAdapterCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testUpsertPlayers(): void
    {
        $playerAdapterCommand = new PlayerAdapterCommand(new EloquentTennisPlayer());
        $sportCategory = EloquentSportCategory::factory()->create();

        $player1 = TennisPlayer::fromArray(['id' => 'test1', 'sport_category_id' => $sportCategory->id]);
        $player2 = TennisPlayer::fromArray(['id' => 'test2', 'sport_category_id' => $sportCategory->id]);
        $player3 = TennisPlayer::fromArray(['id' => 'test3', 'sport_category_id' => $sportCategory->id]);
        $players = TennisPlayers::fromArray([$player1, $player2, $player3]);

        $playerAdapterCommand->upsertById($players);

        $this->assertDatabaseCount('tennis_players', 3);
        $this->assertDatabaseHas('tennis_players', ['id' => 'test1']);
        $this->assertDatabaseHas('tennis_players', ['id' => 'test2']);
        $this->assertDatabaseHas('tennis_players', ['id' => 'test3']);
    }
}
