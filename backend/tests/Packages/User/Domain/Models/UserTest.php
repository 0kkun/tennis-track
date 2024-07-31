<?php

declare(strict_types=1);

namespace Tests\Packages\User\Domain\Models;

use PHPUnit\Framework\TestCase;
use TennisTrack\User\Domain\Models\User;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::fromArray([
            'id' => 1,
            'name' => 'test',
            'email' => 'test@example.com',
        ]);
    }

    public function testCanCreatedWithUserArray(): void
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function testId(): void
    {
        $this->assertEquals(1, $this->user->id()->toInt());
    }

    public function testName(): void
    {
        $this->assertEquals('test', $this->user->name()->toString());
    }

    public function testEmail(): void
    {
        $this->assertEquals('test@example.com', $this->user->email()->toString());
    }
}
