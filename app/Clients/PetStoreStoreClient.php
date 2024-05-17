<?php

namespace App\Clients;

use App\Clients\Contracts\PetStoreClientContract;
use App\Http\Responses\PetStoreCollectionResponse;
use App\Http\Responses\PetStoreResponse;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class PetStoreStoreClient implements PetStoreClientContract
{
    protected string $baseUrl = 'https://petstore.swagger.io/v2';

    public function index(string $status): PetStoreCollectionResponse
    {
        try {
            $response = Http::get(url: "{$this->baseUrl}/pet/findByStatus", query: ['status' => $status]);
        } catch (ConnectionException $e) {
            return PetStoreCollectionResponse::fromArray(data: [
                'status_code' => 500,
                'success' => false,
                'data' => ['message' => $e->getMessage()],
            ]);
        }

        return PetStoreCollectionResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            ['data' => $response->json() ?? []]
        ));
    }

    public function find(string $id): PetStoreResponse
    {
        try {
            $response = Http::get(url: "{$this->baseUrl}/pet/{$id}");
        } catch (ConnectionException $e) {
            return PetStoreResponse::fromArray(data: [
                'status_code' => 500,
                'success' => false,
                'pet' => null,
            ]);
        }

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json() ?? []
        ));
    }

    public function store(array $data): PetStoreResponse
    {
        try {
            $response = Http::post(url: "{$this->baseUrl}/pet", data: $data);
        } catch (ConnectionException $e) {
            return PetStoreResponse::fromArray(data: [
                'status_code' => 500,
                'success' => false,
                'pet' => null,
            ]);
        }

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json() ?? []
        ));
    }

    public function update(array $data): PetStoreResponse
    {
        try {
            $response = Http::put(url: "{$this->baseUrl}/pet", data: $data);
        } catch (ConnectionException $e) {
            return PetStoreResponse::fromArray(data: [
                'status_code' => 500,
                'success' => false,
                'pet' => null,
            ]);
        }

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json() ?? []
        ));
    }

    public function delete(string $id): PetStoreResponse
    {
        try {
            $response = Http::delete(url: "{$this->baseUrl}/pet/{$id}");
        } catch (ConnectionException $e) {
            return PetStoreResponse::fromArray(data: [
                'status_code' => 500,
                'success' => false,
                'pet' => null,
            ]);
        }

        return PetStoreResponse::fromArray(data: array_merge(
            [
                'status_code' => $response->status(),
                'success' => $response->successful(),
            ],
            $response->json() ?? []
        ));
    }
}