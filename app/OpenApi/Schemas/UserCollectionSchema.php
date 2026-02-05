<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserCollection',
    type: 'object',
    description: 'Пагинированная коллекция пользователей',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            description: 'Массив пользователей на текущей странице',
            items: new OA\Items(ref: '#/components/schemas/UserResource')
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
#[OA\Schema(
    schema: 'UserCollectionWithStats',
    type: 'object',
    description: 'Пагинированная коллекция пользователей со статистикой',
    allOf: [
        new OA\Schema(ref: '#/components/schemas/UserCollection'),
        new OA\Schema(
            properties: [
                new OA\Property(
                    property: 'statistics',
                    type: 'object',
                    description: 'Общая статистика по пользователям',
                    properties: [
                        new OA\Property(
                            property: 'total',
                            type: 'integer',
                            description: 'Общее количество пользователей',
                            example: 150
                        ),
                        new OA\Property(
                            property: 'admins',
                            type: 'integer',
                            description: 'Количество администраторов',
                            example: 5
                        ),
                        new OA\Property(
                            property: 'active',
                            type: 'integer',
                            description: 'Количество активных пользователей (вошли за последние 30 дней)',
                            example: 120
                        ),
                        new OA\Property(
                            property: 'verified',
                            type: 'integer',
                            description: 'Количество подтвержденных пользователей',
                            example: 140
                        ),
                    ]
                ),
            ]
        ),
    ]
)]
#[OA\Schema(
    schema: 'UserCollectionSimple',
    type: 'object',
    description: 'Простая коллекция пользователей без пагинации',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            description: 'Массив пользователей',
            items: new OA\Items(ref: '#/components/schemas/UserResource')
        ),
        new OA\Property(
            property: 'count',
            type: 'integer',
            description: 'Общее количество пользователей в коллекции',
            example: 25
        ),
    ]
)]
class UserCollectionSchema {}
