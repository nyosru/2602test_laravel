<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Product',
    type: 'object',
    description: 'Модель продукта',
    required: ['id', 'name', 'price'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Ноутбук HP'),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Мощный ноутбук для работы и игр'
        ),
        new OA\Property(
            property: 'price',
            type: 'number',
            format: 'float',
            example: 899.99,
            description: 'Цена в рублях'
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2024-01-15 10:30:00'
        ),
        new OA\Property(
            property: 'updated_at',
            type: 'string',
            format: 'date-time',
            example: '2024-01-15 10:30:00'
        ),
    ]
)]
class ProductSchema
{
}
