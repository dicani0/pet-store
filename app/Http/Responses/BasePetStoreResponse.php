<?php

namespace App\Http\Responses;

abstract class BasePetStoreResponse
{
    abstract public static function fromArray(array $data): self;

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return match ($this->statusCode) {
            '400' => 'Invalid ID supplied',
            '404' => 'Pet not found',
            '405' => 'Invalid input',
            '500' => 'Internal server error',
            default => 'An error occurred',
        };
    }
}