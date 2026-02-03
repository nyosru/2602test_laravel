<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Product",
    type: "object",
    title: "Product",
    description: "Товар в каталоге",
    required: ["id", "name", "price"]
)]
class ProductSchema
{
    #[OA\Property(
        property: "id",
        description: "Уникальный идентификатор",
        type: "integer",
        readOnly: true,
        example: 145
    )]
    private int $id;

    #[OA\Property(
        property: "name",
        description: "Название товара",
        type: "string",
        maxLength: 255,
        example: "Беспроводные наушники Sony WH-1000XM5"
    )]
    private string $name;

    #[OA\Property(
        property: "description",
        description: "Описание (может отсутствовать)",
        type: "string",
        nullable: true,
        example: "Шумоподавление, 30 часов работы"
    )]
    private ?string $description;

    #[OA\Property(
        property: "price",
        description: "Цена",
        type: "number",
        format: "float",
        minimum: 0,
        example: 349.99
    )]
    private float $price;

}
