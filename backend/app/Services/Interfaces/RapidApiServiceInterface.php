<?php

namespace App\Services\Interfaces;

interface RapidApiServiceInterface
{
    public function getAtpRankings();

    public function getPlayer(int $id);
}
