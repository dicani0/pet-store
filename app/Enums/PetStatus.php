<?php

namespace App\Enums;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

enum PetStatus: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function toArray(): array
    {
        return Arr::mapWithKeys(
            array: self::cases(),
            callback: fn(PetStatus $value) => [$value->name => $value->value]
        );
    }

    public function getLabel(): string
    {
        return Str::title($this->value);
    }
}
