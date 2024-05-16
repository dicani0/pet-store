<?php

namespace App\ValueObjects;

class Pet
{
    /**
     * @param  string  $id
     * @param ?string  $name
     * @param ?Category  $category
     * @param  array  $photoUrls
     * @param ?string  $status
     * @param  array<Tag>  $tags
     */
    public function __construct(
        protected string $id,
        protected ?string $name = null,
        protected ?Category $category = null,
        protected array $photoUrls = [],
        protected ?string $status = null,
        protected array $tags = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $tags = array_map(callback: fn(array $tag) => Tag::fromArray(data: $tag), array: $data['tags'] ?? []);

        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            category: array_key_exists(key: 'category', array: $data) ?
                Category::fromArray(data: $data['category']) : null,
            photoUrls: $data['photoUrls'] ?? [],
            status: $data['status'] ?? null,
            tags: $tags,
        );
    }

    public static function fromRequest(array $data): self
    {
        $tags = array_map(
            callback: fn(array $tag) => Tag::fromArray(data: $tag),
            array: $data['tags'] ?? []
        );
        $photoUrls = array_key_exists(
            key: 'photoUrls',
            array: $data
        ) ? array_filter(
            array: explode(
                separator: ',',
                string: $data['photoUrls']
            )
        ) : [];

        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            category: Category::fromArray([
                'id' => array_key_exists(key: 'category_id', array: $data) ? $data['category_id'] : null,
                'name' => array_key_exists(key: 'category_name', array: $data) ? $data['category_name'] : null,
            ]),
            photoUrls: $photoUrls,
            status: $data['status'] ?? null,
            tags: $tags,
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getPhotoUrls(): array
    {
        return $this->photoUrls;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}