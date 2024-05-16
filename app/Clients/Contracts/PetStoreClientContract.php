<?php

namespace App\Clients\Contracts;

use App\Http\Responses\PetStoreCollectionResponse;
use App\Http\Responses\PetStoreResponse;

interface PetStoreClientContract
{
    public function index(string $status): PetStoreCollectionResponse;

    public function find(string $id): PetStoreResponse;

    public function store(array $data): PetStoreResponse;

    public function update(array $data): PetStoreResponse;

    public function delete(string $id): PetStoreResponse;
}