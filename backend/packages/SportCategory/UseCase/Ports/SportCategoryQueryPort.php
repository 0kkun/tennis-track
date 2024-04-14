<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\UseCase\Ports;

use TennisTrack\SportCategory\Domain\Models\SportCategory;

interface SportCategoryQueryPort
{
    /**
     * @param string $name
     * @return SportCategory
     */
    public function getByName(string $name): SportCategory;
}
