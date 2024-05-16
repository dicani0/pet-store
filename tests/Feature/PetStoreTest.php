<?php

namespace Tests\Feature;

use App\Http\Responses\PetStoreCollectionResponse;
use App\Http\Responses\PetStoreResponse;
use App\Services\Contracts\PetServiceContract;
use App\ValueObjects\Category;
use App\ValueObjects\Pet;
use App\ValueObjects\Tag;
use Mockery;
use Tests\TestCase;

class PetStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $pets = [
            new Pet(
                id: '1',
                name: 'Doggo',
                category: new Category(id: '1', name: 'Dogs'),
                photoUrls: ['http://example.com/photo1.jpg'],
                status: 'available',
                tags: [new Tag(id: '1', name: 'cute')]
            ),
            new Pet(
                id: '2',
                name: 'Kitty',
                category: new Category(id: '2', name: 'Cats'),
                photoUrls: ['http://example.com/photo2.jpg'],
                status: 'pending',
                tags: [new Tag(id: '2', name: 'fluffy')]
            ),
        ];

        $this->mock(PetServiceContract::class, function ($mock) use ($pets) {
            $mock->shouldReceive(methodNames: 'findPets')
                ->once()
                ->andReturn(new PetStoreCollectionResponse(statusCode: '200', success: true, pets: $pets));
        });

        $response = $this->get(uri: route(name: 'pet.index', parameters: ['status' => 'available']));

        $response->assertStatus(status: 200);
        $response->assertViewHas(key: 'pets', value: $pets);
    }

    public function test_index_unknown_status(): void
    {
        $response = $this->get(uri: route(name: 'pet.index', parameters: ['status' => 'wrong_status']));

        $response->assertStatus(status: 302);

        $response->assertSessionHasErrors(keys: ['status' => 'The selected status is invalid.']);
    }

    public function test_show()
    {
        $pet = new Pet(
            id: '1',
            name: 'Doggo',
            category: new Category(id: '1', name: 'Dogs'),
            photoUrls: ['http://example.com/photo1.jpg'],
            status: 'available',
            tags: [new Tag(id: '1', name: 'cute')]
        );

        $this->mock(PetServiceContract::class, function ($mock) use ($pet) {
            $mock->shouldReceive(methodNames: 'findPet')
                ->once()
                ->with('1')
                ->andReturn(new PetStoreResponse(statusCode: '200', success: true, pet: $pet));
        });

        $response = $this->get(route(name: 'pet.show', parameters: ['id' => '1']));

        $response->assertStatus(status: 200);
        $response->assertViewHas(key: 'pet', value: $pet);
    }

    public function test_show_not_found()
    {

        $this->mock(PetServiceContract::class, function ($mock) {
            $mock->shouldReceive(methodNames: 'findPet')
                ->once()
                ->with('1')
                ->andReturn(new PetStoreResponse(statusCode: '404', success: false, pet: null));
        });

        $response = $this->get(route(name: 'pet.show', parameters: ['id' => '1']));
        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Pet not found']);
    }

    public function test_create()
    {
        $response = $this->get(route(name: 'pet.create'));

        $response->assertStatus(status: 200);
    }

    public function test_store()
    {
        $petData = [
            'id' => '1',
            'name' => 'Doggo',
            'category_id' => '1',
            'category_name' => 'Dogs',
            'photoUrls' => 'http://example.com/photo1.jpg',
            'status' => 'available',
            'tags' => [
                [
                    'id' => '1',
                    'name' => 'cute',
                ],
            ],
        ];

        $pet = Pet::fromRequest(data: $petData);

        $this->mock(PetServiceContract::class, function ($mock) use ($pet) {
            $mock->shouldReceive(methodNames: 'storePet')
                ->with(Mockery::on(function (Pet $arg) use ($pet) {
                    return $arg->getId() === $pet->getId()
                        && $arg->getName() === $pet->getName()
                        && $arg->getCategory()->getId() === $pet->getCategory()->getId()
                        && $arg->getCategory()->getName() === $pet->getCategory()->getName()
                        && $arg->getPhotoUrls() === $pet->getPhotoUrls()
                        && $arg->getStatus() === $pet->getStatus()
                        && $arg->getTags()[0]->getName() === $pet->getTags()[0]->getName()
                        && $arg->getTags()[0]->getId() === $pet->getTags()[0]->getId();
                }))
                ->andReturn(new PetStoreResponse(statusCode: '200', success: true, pet: $pet));
        });

        $response = $this->post(route(name: 'pet.store'), $petData);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_store_invalid_input()
    {
        $petData = [
            'id' => '1',
            'name' => 'Doggo',
            'category_id' => '1',
            'category_name' => 'Dogs',
            'photoUrls' => 'http://example.com/photo1.jpg',
            'status' => 'available',
            'tags' => [
                [
                    'id' => '1',
                    'name' => 'cute',
                ],
            ],
        ];

        $pet = Pet::fromRequest(data: $petData);

        $this->mock(PetServiceContract::class, function ($mock) use ($pet) {
            $mock->shouldReceive(methodNames: 'storePet')
                ->with(Mockery::on(function (Pet $arg) use ($pet) {
                    return $arg->getId() === $pet->getId()
                        && $arg->getName() === $pet->getName()
                        && $arg->getCategory()->getId() === $pet->getCategory()->getId()
                        && $arg->getCategory()->getName() === $pet->getCategory()->getName()
                        && $arg->getPhotoUrls() === $pet->getPhotoUrls()
                        && $arg->getStatus() === $pet->getStatus()
                        && $arg->getTags()[0]->getName() === $pet->getTags()[0]->getName()
                        && $arg->getTags()[0]->getId() === $pet->getTags()[0]->getId();
                }))
                ->andReturn(new PetStoreResponse(statusCode: '405', success: false, pet: null));
        });

        $response = $this->post(route(name: 'pet.store'), $petData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Invalid input']);
    }

    public function test_edit()
    {
        $pet = new Pet(
            id: '1',
            name: 'Doggo',
            category: new Category(id: '1', name: 'Dogs'),
            photoUrls: ['http://example.com/photo1.jpg'],
            status: 'available',
            tags: [new Tag(id: '1', name: 'cute')]
        );

        $this->mock(PetServiceContract::class, function ($mock) use ($pet) {
            $mock->shouldReceive(methodNames: 'findPet')
                ->once()
                ->with('1')
                ->andReturn(new PetStoreResponse(statusCode: '200', success: true, pet: $pet));
        });

        $response = $this->get(route(name: 'pet.edit', parameters: ['id' => '1']));

        $response->assertStatus(status: 200);
        $response->assertViewHas(key: 'pet', value: $pet);
    }

    public function test_edit_not_found()
    {
        $this->mock(PetServiceContract::class, function ($mock) {
            $mock->shouldReceive(methodNames: 'findPet')
                ->once()
                ->with('1')
                ->andReturn(new PetStoreResponse(statusCode: '404', success: false, pet: null));
        });

        $response = $this->get(route(name: 'pet.edit', parameters: ['id' => '1']));
        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Pet not found']);
    }

    public function test_update()
    {
        $petData = [
            'id' => '1',
            'name' => 'Doggo',
            'category_id' => '1',
            'category_name' => 'Dogs',
            'photoUrls' => 'http://example.com/photo1.jpg',
            'status' => 'available',
            'tags' => [
                [
                    'id' => '1',
                    'name' => 'cute',
                ],
            ],
        ];

        $pet = Pet::fromRequest(data: $petData);

        $this->mock(PetServiceContract::class, function ($mock) use ($pet) {
            $mock->shouldReceive(methodNames: 'updatePet')
                ->with(Mockery::on(function (Pet $arg) use ($pet) {
                    return $arg->getId() === $pet->getId()
                        && $arg->getName() === $pet->getName()
                        && $arg->getCategory()->getId() === $pet->getCategory()->getId()
                        && $arg->getCategory()->getName() === $pet->getCategory()->getName()
                        && $arg->getPhotoUrls() === $pet->getPhotoUrls()
                        && $arg->getStatus() === $pet->getStatus()
                        && $arg->getTags()[0]->getName() === $pet->getTags()[0]->getName()
                        && $arg->getTags()[0]->getId() === $pet->getTags()[0]->getId();
                }))
                ->andReturn(new PetStoreResponse(statusCode: '200', success: true, pet: $pet));
        });

        $response = $this->put(route(name: 'pet.update', parameters: ['id' => '1']), $petData);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_update_invalid_input()
    {
        $petData = [
            'id' => '1',
            'name' => 'Doggo',
            'category_id' => '1',
            'category_name' => 'Dogs',
            'photoUrls' => 'http://example.com/photo1.jpg',
            'status' => 'available',
            'tags' => [
                [
                    'id' => '1',
                    'name' => 'cute',
                ],
            ],
        ];

        $pet = Pet::fromRequest(data: $petData);

        $this->mock(PetServiceContract::class, function ($mock) use ($pet) {
            $mock->shouldReceive(methodNames: 'updatePet')
                ->with(Mockery::on(function (Pet $arg) use ($pet) {
                    return $arg->getId() === $pet->getId()
                        && $arg->getName() === $pet->getName()
                        && $arg->getCategory()->getId() === $pet->getCategory()->getId()
                        && $arg->getCategory()->getName() === $pet->getCategory()->getName()
                        && $arg->getPhotoUrls() === $pet->getPhotoUrls()
                        && $arg->getStatus() === $pet->getStatus()
                        && $arg->getTags()[0]->getName() === $pet->getTags()[0]->getName()
                        && $arg->getTags()[0]->getId() === $pet->getTags()[0]->getId();
                }))
                ->andReturn(new PetStoreResponse(statusCode: '405', success: false, pet: null));
        });

        $response = $this->put(route(name: 'pet.update', parameters: ['id' => '1']), $petData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Invalid input']);
    }

    public function test_delete()
    {
        $this->mock(PetServiceContract::class, function ($mock) {
            $mock->shouldReceive(methodNames: 'deletePet')
                ->once()
                ->with('1')
                ->andReturn(new PetStoreResponse(statusCode: '200', success: true, pet: null));
        });

        $response = $this->delete(route(name: 'pet.destroy', parameters: ['id' => '1']));

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_delete_not_found()
    {
        $this->mock(PetServiceContract::class, function ($mock) {
            $mock->shouldReceive(methodNames: 'deletePet')
                ->once()
                ->with('1')
                ->andReturn(new PetStoreResponse(statusCode: '404', success: false, pet: null));
        });

        $response = $this->delete(route(name: 'pet.destroy', parameters: ['id' => '1']));
        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Pet not found']);
    }
}
