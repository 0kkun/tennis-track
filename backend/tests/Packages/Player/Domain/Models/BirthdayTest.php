<?php

namespace Tests\Packages\Player\Domain\Models;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use TennisTrack\Common\Exceptions\RuntimeException;
use TennisTrack\Player\Domain\Models\Birthday;

class BirthdayTest extends TestCase
{
    public function testBirthdayAge()
    {
        $birthday = Birthday::from(Carbon::parse('1990-01-01'));
        $now = Carbon::parse('2024-03-26');
        $this->assertEquals(34, $birthday->age($now));
    }

    public function testBirthdayAgeNull()
    {
        $this->expectException(RuntimeException::class);
        $birthday = Birthday::from(null);
        $now = Carbon::parse('2024-03-26');
        $birthday->age($now);
    }
}
