<?php

namespace Tests\Packages\SportCategory\Domain\Models;


use TennisTrack\Common\Exceptions\InvalidArgumentException;
use TennisTrack\SportCategory\Domain\Models\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testTennis()
    {
        $name = Name::from('Tennis');
        $this->assertTrue($name->isTennis());
    }

    public function testSoccer()
    {
        $name = Name::from('Soccer');
        $this->assertTrue($name->isSoccer());
    }

    public function testBaseBall()
    {
        $name = Name::from('BaseBall');
        $this->assertTrue($name->isBaseBall());
    }

    public function testInvalidError()
    {
        $this->expectException(InvalidArgumentException::class);
        Name::from('invalid');
    }

    public function testGetCategoryNames()
    {
        $categoryNames = Name::getCategoryNames();
        $this->assertEquals(['Tennis', 'Soccer', 'BaseBall'], $categoryNames);
    }
}
