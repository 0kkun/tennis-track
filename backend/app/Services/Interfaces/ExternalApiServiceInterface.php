<?php

namespace App\Services\Interfaces;

use TennisTrack\SportRadar\Domain\Models\Path;

interface ExternalApiServiceInterface
{
    /**
     * @param Path $path
     * @return mixed
     */
    public function execute(Path $path): mixed;
}
