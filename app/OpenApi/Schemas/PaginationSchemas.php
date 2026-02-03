<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PaginationLinks',
    type: 'object',
    description: 'Ссылки для навигации по страницам',
    properties: [
        new OA\Property(
            property: 'first',
            type: 'string',
            format: 'uri',
            nullable: true,
            description: 'Ссылка на первую страницу',
            example: 'http://api.example.com/api/products?page=1'
        ),
        new OA\Property(
            property: 'last',
            type: 'string',
            format: 'uri',
            nullable: true,
            description: 'Ссылка на последнюю страницу',
            example: 'http://api.example.com/api/products?page=10'
        ),
        new OA\Property(
            property: 'prev',
            type: 'string',
            format: 'uri',
            nullable: true,
            description: 'Ссылка на предыдущую страницу',
            example: null
        ),
        new OA\Property(
            property: 'next',
            type: 'string',
            format: 'uri',
            nullable: true,
            description: 'Ссылка на следующую страницу',
            example: 'http://api.example.com/api/products?page=2'
        ),
    ]
)]
#[OA\Schema(
    schema: 'PaginationMeta',
    type: 'object',
    description: 'Пагинационная мета-информация',
    properties: [
        new OA\Property(
            property: 'current_page',
            type: 'integer',
            description: 'Текущая страница',
            example: 1
        ),
        new OA\Property(
            property: 'from',
            type: 'integer',
            nullable: true,
            description: 'Номер первого элемента на текущей странице',
            example: 1
        ),
        new OA\Property(
            property: 'to',
            type: 'integer',
            nullable: true,
            description: 'Номер последнего элемента на текущей странице',
            example: 15
        ),
        new OA\Property(
            property: 'per_page',
            type: 'integer',
            description: 'Количество элементов на одной странице',
            example: 15
        ),
        new OA\Property(
            property: 'total',
            type: 'integer',
            description: 'Общее количество элементов',
            example: 142
        ),
        new OA\Property(
            property: 'last_page',
            type: 'integer',
            description: 'Последняя доступная страница',
            example: 10
        ),
    ]
)]
#[OA\Schema(
    schema: 'PaginatedProductResponse',
    type: 'object',
    description: 'Пагинированный список продуктов',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            description: 'Массив продуктов',
            items: new OA\Items(ref: '#/components/schemas/ProductResource')
        ),
        new OA\Property(
            property: 'links',
            ref: '#/components/schemas/PaginationLinks'
        ),
        new OA\Property(
            property: 'meta',
            ref: '#/components/schemas/PaginationMeta'
        ),
    ]
)]
class PaginationSchemas {}
