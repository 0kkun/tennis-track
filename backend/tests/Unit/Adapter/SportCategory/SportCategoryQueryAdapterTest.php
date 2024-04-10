<?php

declare(strict_types=1);

namespace Tests\Unit\Adapter\SportCategory;

use App\Adapter\SportCategory\SportCategoryQueryAdapter;
use App\Eloquents\EloquentSportCategory;
use TennisTrack\SportCategory\Domain\Models\SportCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SportCategoryQueryAdapterTest extends TestCase
{
    use RefreshDatabase;

    public function testGetByName()
    {
        $sportCategoryQueryAdapter = new SportCategoryQueryAdapter(new EloquentSportCategory());
        $sportCategory = EloquentSportCategory::factory()->create(['name' => 'Tennis']);

        $sportCategory = $sportCategoryQueryAdapter->getByName('Tennis');

        $this->assertInstanceOf(SportCategory::class, $sportCategory);
        $this->assertEquals('Tennis', $sportCategory->name()->toString());
    }
}
