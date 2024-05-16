<?php

namespace App\ValueObjects;

class Tag
{
    /**
     * @param  ?string  $id
     * @param  ?string  $name
     */
    public function __construct(
        protected ?string $id,
        protected ?string $name
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: array_key_exists('id', $data) ? $data['id'] : null,
            name: array_key_exists('name', $data) ? $data['name'] : null,
        );
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}