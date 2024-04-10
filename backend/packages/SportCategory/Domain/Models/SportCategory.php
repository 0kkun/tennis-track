<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\Domain\Models;

final class SportCategory
{
    private Id $id;
    private Name $name;

    /**
     * @param Id $id
     * @param Name $name
     */
    private function __construct(Id $id, Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Id::from($data['id']),
            Name::from($data['name'])
        );
    }
}
