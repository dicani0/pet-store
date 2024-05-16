<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pet\IndexPetsRequest;
use App\Http\Requests\Pet\ShowPetRequest;
use App\Http\Requests\Pet\StorePetRequest;
use App\Services\Contracts\PetServiceContract;
use App\ValueObjects\Pet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetStoreController extends Controller
{
    public function __construct(protected PetServiceContract $petService)
    {
    }

    public function index(IndexPetsRequest $request): View
    {
        $response = $this->petService->findPets(status: $request->get('status'));
        return view(view: 'pets.index', data: ['pets' => $response->getPets()]);
    }

    public function create(): View
    {
        return view(view: 'pets.form');
    }

    public function store(StorePetRequest $request): View|RedirectResponse
    {
        $response = $this->petService->storePet(pet: Pet::fromRequest(data: $request->validated()));

        return $response->isSuccess() ? redirect()->route(
            route: 'pet.show',
            parameters: ['id' => $response->getPet()?->getId()]
        ) : redirect()->route(route: 'pet.create')->withErrors(provider: ['error' => $response->getMessage()]);
    }

    public function find(Request $request): View
    {
        return view(view: 'pets.find');
    }

    public function findByStatus(Request $request): View
    {
        return view(view: 'pets.find-by-status');
    }

    public function show(ShowPetRequest $request): View|RedirectResponse
    {
        $response = $this->petService->findPet(id: $request->get('id'));

        return $response->isSuccess() ? view(
            view: 'pets.show',
            data: ['pet' => $response->getPet()]
        ) : redirect()->route(route: 'pet.find')->withErrors(provider: ['error' => $response->getMessage()]);
    }

    public function edit(string $id): View|RedirectResponse
    {
        $response = $this->petService->findPet(id: $id);

        return $response->isSuccess() ? view(
            view: 'pets.form',
            data: ['pet' => $response->getPet()]
        ) : redirect()->route(route: 'pet.find')->withErrors(provider: ['error' => $response->getMessage()]);
    }

    public function update(StorePetRequest $request): View|RedirectResponse
    {
        $pet = Pet::fromRequest(data: $request->validated());
        $response = $this->petService->updatePet(pet: $pet);

        return $response->isSuccess() ? redirect()->route(
            route: 'pet.show',
            parameters: ['id' => $response->getPet()?->getId()]
        ) : redirect()->route(route: 'pet.edit',
            parameters: ['id' => $pet->getId()])->withErrors(provider: ['error' => $response->getMessage()]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $response = $this->petService->deletePet(id: $id);

        return $response->isSuccess() ?
            redirect()->route(route: 'pet.find') :
            redirect()->route(route: 'pet.show')->withErrors(provider: ['error' => $response->getMessage()]);
    }
}
