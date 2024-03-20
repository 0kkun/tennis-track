<?php
namespace Tests\Packages\SportRadar\Models;

use TennisTrack\Common\ValueObject\ValueObjectString;
use TennisTrack\Common\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValueObjectStringTestDummy {
    use ValueObjectString;
}

class ValueObjectStringTest extends TestCase
{
    public function testStringInitialization(): void
    {
        $valueObject = ValueObjectStringTestDummy::from('valid value');
        $this->assertSame('valid value', $valueObject->toString());
    }

    public function testDefaultStringValue(): void
    {
        $valueObject = ValueObjectStringTestDummy::from();
        $this->assertSame('', $valueObject->toString());
    }

    public function testStringEquality(): void
    {
        $valueObject1 = ValueObjectStringTestDummy::from('valid value');
        $valueObject2 = ValueObjectStringTestDummy::from('valid value');
        $this->assertTrue($valueObject1->equals($valueObject2));
    }

    public function testStringInequality(): void
    {
        $valueObject1 = ValueObjectStringTestDummy::from('valid value');
        $valueObject2 = ValueObjectStringTestDummy::from('another valid value');
        $this->assertFalse($valueObject1->equals($valueObject2));
    }

    public function testStringFromString(): void
    {
        $valueObject = ValueObjectStringTestDummy::from('valid value');
        $this->assertInstanceOf(ValueObjectStringTestDummy::class, $valueObject);
        $this->assertSame('valid value', $valueObject->toString());
    }

    public function testStringFromNull(): void
    {
        $valueObject = ValueObjectStringTestDummy::from(null);
        $this->assertInstanceOf(ValueObjectStringTestDummy::class, $valueObject);
        $this->assertSame('', $valueObject->toString());
    }

    public function testStringFromInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ValueObjectStringTestDummy::from(10);
    }
}