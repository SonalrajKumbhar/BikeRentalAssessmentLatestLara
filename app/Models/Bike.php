<?php

namespace App\Models;

/**
 * Bike Model
 * Represents a bike in the rental system
 */
class Bike
{
    private int $id;
    private string $name;
    private string $type;
    private float $price;
    private bool $available;
    private string $description;
    private ?string $imageUrl;

    public function __construct(
        int $id,
        string $name,
        string $type,
        float $price,
        bool $available,
        string $description = '',
        ?string $imageUrl = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->price = $price;
        $this->available = $available;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    /**
     * Convert model to array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'price' => $this->price,
            'available' => $this->available,
            'description' => $this->description,
            'imageUrl' => $this->imageUrl,
        ];
    }

    /**
     * Convert model to JSON-ready array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Create Bike from array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? 0,
            $data['name'] ?? '',
            $data['type'] ?? '',
            $data['price'] ?? 0,
            $data['available'] ?? true,
            $data['description'] ?? '',
            $data['imageUrl'] ?? null
        );
    }
}
