<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[
OA\Schema(
    schema: 'ProductResource',
    type: 'object',
    description: 'Продукт в ответе API',
    required: ['id', 'name', 'price'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Ноутбук HP'),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Мощный ноутбук для работы'
        ),
        new OA\Property(
            property: 'price',
            type: 'number',
            format: 'float',
            example: 899.99
        ),
        new OA\Property(
            property: 'price_formatted',
            type: 'string',
            example: '899.99',
            description: 'Отформатированная цена'
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
//        new OA\Property(
//            property: 'links',
//            type: 'object',
//            properties: [
//                new OA\Property(
//                    property: 'self',
//                    type: 'string',
//                    format: 'uri',
//                    example: 'http://api.example.com/api/products/1'
//                )
//            ]
//        ),

    ]
)]
class ProductResourceSchema
{
}
