<?php

declare(strict_types=1);

namespace TennisTrack\User\Domain\Models;

final class User
{
    private Id $id;
    private Name $name;
    private Email $email;

    public function __construct(Id $id, Name $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Id::from($data['id'] ?? 0),
            Name::from($data['name'] ?? ''),
            Email::from($data['email'] ?? '')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toInt(),
            'name' => $this->name->toString(),
            'email' => $this->email->toString(),
        ];
    }
}
