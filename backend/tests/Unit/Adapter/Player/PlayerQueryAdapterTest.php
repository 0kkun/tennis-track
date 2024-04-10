<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\Player;

use App\Adapter\Player\PlayerQueryAdapter;
use App\Eloquents\EloquentPlayer;
use App\Eloquents\EloquentSportCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TennisTrack\SportCategory\Domain\Models\Id as SportCategoryId;
use Tests\TestCase;

class PlayerQueryAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchBySportCategoryId(): void
    {
        $playerAdapterCommand = new PlayerQueryAdapter(new EloquentPlayer());
        $sportCategory = EloquentSportCategory::factory()->create(['id' => 1]);

        $player1 = EloquentPlayer::factory()->create(['id' => 'test1', 'sport_category_id' => $sportCategory->id]);
        $player2 = EloquentPlayer::factory()->create(['id' => 'test2', 'sport_category_id' => $sportCategory->id]);

        $result = $playerAdapterCommand->fetchBySportCategoryId(SportCategoryId::from($sportCategory->id));

        $this->assertEquals(2, count($result));
        $this->assertEquals($player1->id, $result[0]['id']);
        $this->assertEquals($player2->id, $result[1]['id']);
    }
}
