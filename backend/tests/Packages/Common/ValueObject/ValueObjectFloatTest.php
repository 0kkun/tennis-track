<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\Common\ValueObject\ValueObjectFloat;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValueObjectFloatTestDummy {
    use ValueObjectFloat;
}

class ValueObjectFloatTest extends TestCase
{
    public function testFloatInitialization(): void
    {
        $valueObject = ValueObjectFloatTestDummy::from(10.5);
        $this->assertSame(10.5, $valueObject->toFloat());
    }

    public function testDefaultFloatValue(): void
    {
        $valueObject = ValueObjectFloatTestDummy::from();
        $this->assertSame(0.0, $valueObject->toFloat());
    }

    public function testFloatEquality(): void
    {
        $valueObject1 = ValueObjectFloatTestDummy::from(10.5);
        $valueObject2 = ValueObjectFloatTestDummy::from(10.5);
        $this->assertTrue($valueObject1->equals($valueObject2));
    }

    public function testFloatInequality(): void
    {
        $valueObject1 = ValueObjectFloatTestDummy::from(10.5);
        $valueObject2 = ValueObjectFloatTestDummy::from(20.5);
        $this->assertFalse($valueObject1->equals($valueObject2));
    }

    public function testFloatFromFloat(): void
    {
        $valueObject = ValueObjectFloatTestDummy::from(20.25);
        $this->assertInstanceOf(ValueObjectFloatTestDummy::class, $valueObject);
        $this->assertSame(20.25, $valueObject->toFloat());
    }

    public function testFloatFromNull(): void
    {
        $valueObject = ValueObjectFloatTestDummy::from(null);
        $this->assertInstanceOf(ValueObjectFloatTestDummy::class, $valueObject);
        $this->assertSame(0.0, $valueObject->toFloat());
    }

    public function testFloatFromInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ValueObjectFloatTestDummy::from('not a float');
    }
}
