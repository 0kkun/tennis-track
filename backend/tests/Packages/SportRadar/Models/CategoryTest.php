<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\SportRadar\Domain\Models\Category;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testCategory()
    {
        $category = new Category('players');
        $this->assertEquals('players', $category->toString());
    }

    public function testCategoryInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        new Category('invalid');
    }

    public function testCategoryPlayers()
    {
        $category = Category::players();
        $this->assertEquals('players', $category->toString());
    }

    public function testCategoryTournaments()
    {
        $category = Category::tournaments();
        $this->assertEquals('tournaments', $category->toString());
    }
}
