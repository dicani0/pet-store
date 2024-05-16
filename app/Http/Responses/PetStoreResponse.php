<?php

namespace App\Http\Responses;

use App\ValueObjects\Pet;

class PetStoreResponse extends BasePetStoreResponse
{
    public function __construct(
        protected string $statusCode,
        protected bool $success,
        protected ?Pet $pet,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $pet = isset($data['id']) ? Pet::fromArray($data) : null;

        return new self(
            statusCode: $data['status_code'],
            success: $data['success'],
            pet: $pet,
        );
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }
}