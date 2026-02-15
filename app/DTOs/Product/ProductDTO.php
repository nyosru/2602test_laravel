<?php

namespace App\DTOs\Product;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly float $price,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt
    ) {}

    /**
     * Создание DTO из массива данных
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float) $data['price'],
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null
        );
    }

    /**
     * Создание DTO из модели Eloquent
     */
    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            description: $product->description,
            price: (float) $product->price,
            createdAt: $product->created_at?->toDateTimeString(),
            updatedAt: $product->updated_at?->toDateTimeString()
        );
    }

    /**
     * Создание DTO из Request
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->route('product'),
            name: $request->input('name'),
            description: $request->input('description'),
            price: (float) $request->input('price'),
            createdAt: null,
            updatedAt: null
        );
    }

    /**
     * Преобразование DTO в массив для создания/обновления
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }
}
