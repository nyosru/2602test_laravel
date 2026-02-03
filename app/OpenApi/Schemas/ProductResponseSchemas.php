<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с продуктом',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/ProductResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Продукт получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'ProductsListSuccessResponse',
    type: 'object',
    description: 'Успешный ответ со списком продуктов',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/PaginatedProductResponse'),
        new OA\Property(property: 'message', type: 'string', example: 'Список продуктов получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'ProductCreatedResponse',
    type: 'object',
    description: 'Продукт успешно создан',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/ProductResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Продукт успешно создан'),
        new OA\Property(property: 'code', type: 'integer', example: 201),
    ]
)]
class ProductResponseSchemas {}
