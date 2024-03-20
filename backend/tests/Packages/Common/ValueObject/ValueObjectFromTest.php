<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\Common\ValueObject\ValueObjectFrom;
use PHPUnit\Framework\TestCase;

class ValueObjectFromTestDummy {
    use ValueObjectFrom;
}

class ValueObjectFromTest extends TestCase
{
    public function testFrom(): void
    {
        $valueObject = ValueObjectFromTestDummy::from('valid value');
        $this->assertInstanceOf(ValueObjectFromTestDummy::class, $valueObject);
    }
}