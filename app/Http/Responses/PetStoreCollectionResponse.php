<?php

namespace App\Http\Responses;

use App\ValueObjects\Pet;

class PetStoreCollectionResponse extends BasePetStoreResponse
{
    /**
     * @param  string  $statusCode
     * @param  bool  $success
     * @param  array<Pet>  $pets
     */
    public function __construct(
        protected string $statusCode,
        protected bool $success,
        protected array $pets,
    ) {
    }

    public static function fromArray(array $data): self
    {

        return new self(
            statusCode: $data['status_code'],
            success: $data['success'],
            pets: array_map(
                callback: fn(array $pet) => Pet::fromArray(data: $pet),
                array: $data['data'],
            ),
        );
    }

    /**
     * @return array<Pet>
     */
    public function getPets(): array
    {
        return $this->pets;
    }
}