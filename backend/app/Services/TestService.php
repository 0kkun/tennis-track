<?php

namespace App\Services;

use App\Services\Interfaces\TestServiceInterface;

class TestService implements TestServiceInterface
{
    public function test(): string
    {
        return 'success';
    }
}