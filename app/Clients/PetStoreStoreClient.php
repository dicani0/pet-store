<?php

namespace App\Clients;

use App\Clients\Contracts\PetStoreClientContract;
use App\Http\Responses\PetStoreCollectionResponse;
use App\Http\Responses\PetStoreResponse;
use Illuminate\Support\Facades\Http;

class PetStoreStoreClient implements PetStoreClientContract
{
    protected string $baseUrl = 'https://petstore.swagger.io/v2';

    public function index(string $status): PetStoreCollectionResponse
    {
        $response = Http::get(url: "{$this->baseUrl}/pet/findByStatus", query: ['status' => $status]);

        return PetStoreCollectionResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            ['data' => $response->json()]
        ));
    }

    public function find(string $id): PetStoreResponse
    {
        $response = Http::get(url: "{$this->baseUrl}/pet/{$id}");
        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json()
        ));
    }

    public function store(array $data): PetStoreResponse
    {
        $response = Http::post(url: "{$this->baseUrl}/pet", data: $data);

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json()
        ));
    }

    public function update(array $data): PetStoreResponse
    {
        $response = Http::put(url: "{$this->baseUrl}/pet", data: $data);

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json()
        ));
    }

    public function delete(string $id): PetStoreResponse
    {
        $response = Http::delete(url: "{$this->baseUrl}/pet/{$id}");

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json()
        ));
    }
}