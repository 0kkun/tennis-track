<?php

namespace Tests\Packages\SportRadar\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\Common\ValueObject\ValueObjectFrom;

class ValueObjectFromTestDummy
{
    use ValueObjectFrom;
}

class ValueObjectFromTest extends TestCase
{
    public function testFrom(): void
    {
        $valueObject = ValueObjectFromTestDummy::from('valid value');
        $this->assertInstanceOf(ValueObjectFromTestDummy::class, $valueObject);

        $valueObject = ValueObjectFromTestDummy::from(0);
        $this->assertInstanceOf(ValueObjectFromTestDummy::class, $valueObject);
    }
}
