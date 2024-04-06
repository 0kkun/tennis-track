<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\Ranking;

use App\Adapter\Ranking\TennisRankingCommandAdapter;
use App\Eloquents\EloquentPlayer;
use App\Eloquents\EloquentSportCategory;
use App\Eloquents\EloquentTennisRanking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TennisTrack\Ranking\Domain\Models\TennisRanking;
use TennisTrack\Ranking\Domain\Models\TennisRankings;
use Tests\TestCase;

class TennisRankingCommandAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function testUpsertTennisRanking(): void
    {
        $tennisRankingCommand = new TennisRankingCommandAdapter(new EloquentTennisRanking());
        $sportCategory = EloquentSportCategory::factory()->create();
        $player1 = EloquentPlayer::factory()->create(['id' => 'test1', 'sport_category_id' => $sportCategory->id]);
        $player2 = EloquentPlayer::factory()->create(['id' => 'test2', 'sport_category_id' => $sportCategory->id]);
        $player3 = EloquentPlayer::factory()->create(['id' => 'test3', 'sport_category_id' => $sportCategory->id]);

        $ranking1 = TennisRanking::fromArray([
            'rank' => 1,
            'player_id' => $player1->id,
            'type' => 'singles',
            'point' => 1000,
            'ranking_date' => '2021-01-01',
        ]);
        $ranking2 = TennisRanking::fromArray([
            'rank' => 2,
            'player_id' => $player2->id,
            'type' => 'singles',
            'point' => 1000,
            'ranking_date' => '2021-01-01',
        ]);
        $ranking3 = TennisRanking::fromArray([
            'rank' => 3,
            'player_id' => $player3->id,
            'type' => 'singles',
            'point' => 1000,
            'ranking_date' => '2021-01-01',
        ]);
        $rankings = TennisRankings::fromArray([$ranking1, $ranking2, $ranking3]);

        $tennisRankingCommand->upsert($rankings);

        $this->assertDatabaseCount('tennis_rankings', 3);
        $this->assertDatabaseHas('tennis_rankings', ['rank' => 1]);
        $this->assertDatabaseHas('tennis_rankings', ['rank' => 2]);
        $this->assertDatabaseHas('tennis_rankings', ['rank' => 3]);
    }
}
