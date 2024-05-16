<?php

namespace App\Services\Contracts;

use App\Http\Responses\PetStoreCollectionResponse;
use App\Http\Responses\PetStoreResponse;
use App\ValueObjects\Pet;

interface PetServiceContract
{
    public function findPets(string $status): PetStoreCollectionResponse;

    public function findPet(string $id): PetStoreResponse;

    public function storePet(Pet $pet): PetStoreResponse;

    public function updatePet(Pet $pet): PetStoreResponse;

    public function deletePet(string $id): PetStoreResponse;
}