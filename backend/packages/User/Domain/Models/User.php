<?php

declare(strict_types=1);

namespace TennisTrack\User\Domain\Models;

final class User
{
    /**
     * @param Id $id
     * @param Name $name
     * @param Email $email
     */
    public function __construct(
        private Id $id,
        private Name $name,
        private Email $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
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

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Id::from($data['id'] ?? 0),
            Name::from($data['name'] ?? ''),
            Email::from($data['email'] ?? '')
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->toInt(),
            'name' => $this->name->toString(),
            'email' => $this->email->toString(),
        ];
    }
}
