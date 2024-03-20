<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\Common\ValueObject\ValueObjectInt;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValueObjectIntTestDummy {
    use ValueObjectInt;
}

class ValueObjectIntTest extends TestCase
{
    public function testIntInitialization(): void
    {
        $valueObject = ValueObjectIntTestDummy::from(10);
        $this->assertSame(10, $valueObject->toInt());
    }

    public function testDefaultIntValue(): void
    {
        $valueObject = ValueObjectIntTestDummy::from();
        $this->assertSame(0, $valueObject->toInt());
    }

    public function testIntEquality(): void
    {
        $valueObject1 = ValueObjectIntTestDummy::from(10);
        $valueObject2 = ValueObjectIntTestDummy::from(10);
        $this->assertTrue($valueObject1->equals($valueObject2));
    }

    public function testIntInequality(): void
    {
        $valueObject1 = ValueObjectIntTestDummy::from(10);
        $valueObject2 = ValueObjectIntTestDummy::from(20);
        $this->assertFalse($valueObject1->equals($valueObject2));
    }

    public function testIntFromInt(): void
    {
        $valueObject = ValueObjectIntTestDummy::from(20);
        $this->assertInstanceOf(ValueObjectIntTestDummy::class, $valueObject);
        $this->assertSame(20, $valueObject->toInt());
    }

    public function testIntFromNull(): void
    {
        $valueObject = ValueObjectIntTestDummy::from(null);
        $this->assertInstanceOf(ValueObjectIntTestDummy::class, $valueObject);
        $this->assertSame(0, $valueObject->toInt());
    }

    public function testIntFromInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ValueObjectIntTestDummy::from('not an int');
    }
}