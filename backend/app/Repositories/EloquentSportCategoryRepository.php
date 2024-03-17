<?php

namespace App\Repositories;

use App\Eloquents\EloquentSportCategory;
use App\Repositories\Interfaces\SportCategoryRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentSportCategoryRepository implements SportCategoryRepositoryInterface
{
    /**
     * @param EloquentSportCategory $sportCategory
     */
    public function __construct(private EloquentSportCategory $sportCategory)
    {
        $this->sportCategory = $sportCategory;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll(): ?Collection
    {
        return $this->sportCategory
            ->select('id', 'name')
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getIdByName(string $name): ?int
    {
        return $this->sportCategory
            ->where('name', $name)
            ->first()
            ->id ?? null;
    }
}
