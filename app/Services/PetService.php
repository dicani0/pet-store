<?php

namespace App\Services;

use App\Clients\Contracts\PetStoreClientContract;
use App\Http\Responses\PetStoreCollectionResponse;
use App\Http\Responses\PetStoreResponse;
use App\Services\Contracts\PetServiceContract;
use App\ValueObjects\Pet;
use App\ValueObjects\Tag;

class PetService implements PetServiceContract
{
    public function __construct(protected PetStoreClientContract $client)
    {
    }

    public function findPets(string $status): PetStoreCollectionResponse
    {
        return $this->client->index(status: $status);
    }

    public function findPet(string $id): PetStoreResponse
    {
        return $this->client->find(id: $id);
    }

    public function storePet(Pet $pet): PetStoreResponse
    {
        return $this->client->store(data: [
            'id' => $pet->getId(),
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls() ?? [],
            'status' => $pet->getStatus(),
            'category' => [
                'id' => $pet->getCategory()?->getId(),
                'name' => $pet->getCategory()?->getName(),
            ],
            'tags' => array_map(
                callback: fn(Tag $tag) => [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ],
                array: $pet->getTags()
            ),
        ]);
    }

    public function updatePet(Pet $pet): PetStoreResponse
    {
        return $this->client->store(data: [
            'id' => $pet->getId(),
            'name' => $pet->getName(),
            'photoUrls' => $pet->getPhotoUrls() ?? [],
            'status' => $pet->getStatus(),
            'category' => [
                'id' => $pet->getCategory()?->getId(),
                'name' => $pet->getCategory()?->getName(),
            ],
            'tags' => array_map(
                callback: fn(Tag $tag) => [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ],
                array: $pet->getTags()
            ),
        ]);
    }

    public function deletePet(string $id): PetStoreResponse
    {
        return $this->client->delete(id: $id);
    }
}