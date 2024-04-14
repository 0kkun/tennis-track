<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\Ranking;

use App\Adapter\Ranking\TennisRankingQueryAdapter;
use App\Eloquents\EloquentPlayer;
use App\Eloquents\EloquentSportCategory;
use App\Eloquents\EloquentTennisRanking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TennisTrack\Ranking\Domain\Models\TennisRankings;
use Tests\TestCase;

class TennisRankingQueryAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchForLatest(): void
    {
        $sportCategory = EloquentSportCategory::factory()->create(['name' => 'Tennis']);
        $player1 = EloquentPlayer::factory()->create([
            'id' => 'test1',
            'sport_category_id' => $sportCategory->id,
        ]);
        $player2 = EloquentPlayer::factory()->create([
            'id' => 'test2',
            'sport_category_id' => $sportCategory->id,
        ]);
        EloquentTennisRanking::factory()->create([
            'player_id' => $player1->id,
            'ranking_date' => '2021-01-01',
        ]);
        EloquentTennisRanking::factory()->create([
            'player_id' => $player2->id,
            'ranking_date' => '2021-01-01',
        ]);

        $tennisRankingQuery = new TennisRankingQueryAdapter(new EloquentTennisRanking());

        $result = $tennisRankingQuery->fetchForLatest();
        $this->assertInstanceOf(TennisRankings::class, $result);
        $this->assertCount(2, $result->toArray());
    }
}
