<?php

declare(strict_types=1);

namespace TennisTrack\SportCategory\Domain\Models;

final class SportCategory
{
    /**
     * @param Id $id
     * @param Name $name
     */
    private function __construct(private Id $id, private Name $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return Id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @return Name
     */
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

    /**
     * @return array
     */
    public static function getNames(): array
    {
        return Name::getNames();
    }
}
