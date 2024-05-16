<?php

namespace App\Http\Requests\Pet;

use App\Enums\PetStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'category_name' => ['required', 'string'],
            'status' => ['required', 'string', Rule::enum(type: PetStatus::class)],
            'tags' => ['array'],
            'tags.*.id' => ['string', 'nullable'],
            'tags.*.name' => ['string', 'nullable'],
            'photoUrls' => ['string', 'nullable'],
        ];
    }
}
