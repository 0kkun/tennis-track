<?php

declare(strict_types=1);

namespace App\Adapter\SportCategory;

use App\Eloquents\EloquentSportCategory;
use TennisTrack\SportCategory\Domain\Models\SportCategory;
use TennisTrack\SportCategory\UseCase\Ports\SportCategoryQueryPort;

class SportCategoryQueryAdapter implements SportCategoryQueryPort
{
    /**
     * @param EloquentSportCategory $eloquentSportCategory
     */
    public function __construct(
        private EloquentSportCategory $eloquentSportCategory
    ) {
        $this->eloquentSportCategory = $eloquentSportCategory;
    }

    /**
     * {@inheritDoc}
     */
    public function getByName(string $name): SportCategory
    {
        $result = $this->eloquentSportCategory
            ->where('name', $name)
            ->first();

        return SportCategory::fromArray($result->toArray());
    }
}
