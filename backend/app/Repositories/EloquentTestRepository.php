<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TestRepositoryInterface;

class EloquentTestRepository implements TestRepositoryInterface
{
    public function test(): string
    {
        return 'success';
    }
}