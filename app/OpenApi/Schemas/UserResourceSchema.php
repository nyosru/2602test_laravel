<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserResource',
    type: 'object',
    description: 'Пользователь в ответе API',
    required: ['id', 'name', 'email'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Иван Петров'),
        new OA\Property(
            property: 'email',
            type: 'string',
            format: 'email',
            example: 'user@example.com'
        ),
        new OA\Property(
            property: 'email_verified_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2024-01-15 10:30:00',
            description: 'Дата подтверждения email'
        ),
        new OA\Property(
            property: 'is_admin',
            type: 'boolean',
            example: false,
            description: 'Является ли пользователь администратором'
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
        new OA\Property(
            property: 'links',
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'self',
                    type: 'string',
                    format: 'uri',
                    example: 'http://api.example.com/api/user'
                ),
                new OA\Property(
                    property: 'products',
                    type: 'string',
                    format: 'uri',
                    example: 'http://api.example.com/api/user/products',
                    description: 'Ссылка на продукты пользователя'
                ),
                new OA\Property(
                    property: 'tokens',
                    type: 'string',
                    format: 'uri',
                    example: 'http://api.example.com/api/user/tokens',
                    description: 'Ссылка на токены пользователя'
                ),
            ]
        ),
        new OA\Property(
            property: 'meta',
            type: 'object',
            nullable: true,
            properties: [
                new OA\Property(
                    property: 'products_count',
                    type: 'integer',
                    example: 15,
                    description: 'Количество продуктов пользователя'
                ),
                new OA\Property(
                    property: 'tokens_count',
                    type: 'integer',
                    example: 2,
                    description: 'Количество активных токенов'
                ),
                new OA\Property(
                    property: 'last_login',
                    type: 'string',
                    format: 'date-time',
                    nullable: true,
                    example: '2024-01-20 14:25:00',
                    description: 'Последний вход'
                ),
            ]
        ),
    ]
)]

#[OA\Schema(
    schema: 'UserWithTokenResource',
    type: 'object',
    description: 'Пользователь с токеном в ответе API',
    allOf: [
        new OA\Schema(ref: '#/components/schemas/UserResource'),
        new OA\Schema(
            properties: [
                new OA\Property(
                    property: 'token',
                    type: 'string',
                    example: '1|randomtoken1234567890',
                    description: 'Bearer токен для аутентификации'
                ),
                new OA\Property(
                    property: 'token_expires_at',
                    type: 'string',
                    format: 'date-time',
                    nullable: true,
                    example: '2025-01-15 10:30:00',
                    description: 'Срок действия токена'
                ),
            ]
        ),
    ]
)]

#[OA\Schema(
    schema: 'UserWithTokensResource',
    type: 'object',
    description: 'Пользователь со списком токенов',
    properties: [
        new OA\Property(
            property: 'user',
            ref: '#/components/schemas/UserResource'
        ),
        new OA\Property(
            property: 'tokens',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/UserTokenInfo')
        ),
        new OA\Property(
            property: 'tokens_count',
            type: 'integer',
            example: 3
        ),
        new OA\Property(
            property: 'active_tokens_count',
            type: 'integer',
            example: 2,
            description: 'Количество не истекших токенов'
        ),
    ]
)]

#[OA\Schema(
    schema: 'UserTokenInfo',
    type: 'object',
    description: 'Информация о токене пользователя',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'api-token'),
        new OA\Property(
            property: 'abilities',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['*']
        ),
        new OA\Property(
            property: 'last_used_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2024-01-20 14:25:00'
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2024-01-15 10:30:00'
        ),
        new OA\Property(
            property: 'expires_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2025-01-15 10:30:00'
        ),
        new OA\Property(
            property: 'is_valid',
            type: 'boolean',
            example: true
        ),
    ]
)]


#[OA\Schema(
    schema: 'UserTokenRandomInfo',
    type: 'object',
    description: 'Информация о токене пользователя наугад',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'api-token'),
        new OA\Property(
            property: 'abilities',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['*']
        ),
        new OA\Property(
            property: 'last_used_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2024-01-20 14:25:00'
        ),
        new OA\Property(
            property: 'created_at',
            type: 'string',
            format: 'date-time',
            example: '2024-01-15 10:30:00'
        ),
        new OA\Property(
            property: 'expires_at',
            type: 'string',
            format: 'date-time',
            nullable: true,
            example: '2025-01-15 10:30:00'
        ),
        new OA\Property(
            property: 'is_valid',
            type: 'boolean',
            example: true
        ),
    ]
)]


#[OA\Schema(
    schema: 'CurrentUserWithTokenInfo',
    type: 'object',
    description: 'Текущий пользователь с информацией о токене',
    properties: [
        new OA\Property(
            property: 'user',
            ref: '#/components/schemas/UserResource'
        ),
        new OA\Property(
            property: 'current_token',
            ref: '#/components/schemas/UserTokenInfo'
        ),
        new OA\Property(
            property: 'instructions',
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'header_format',
                    type: 'string',
                    example: 'Authorization: Bearer {token}'
                ),
                new OA\Property(
                    property: 'curl_example',
                    type: 'string',
                    example: 'curl -H "Authorization: Bearer YOUR_TOKEN" http://api.example.com/api/products'
                ),
            ]
        ),
    ]
)]


#[OA\Schema(
    schema: 'UserProfileResource',
    type: 'object',
    description: 'Расширенный профиль пользователя',
    allOf: [
        new OA\Schema(ref: '#/components/schemas/UserResource'),
        new OA\Schema(
            properties: [
                new OA\Property(
                    property: 'profile',
                    type: 'object',
                    nullable: true,
                    properties: [
                        new OA\Property(
                            property: 'avatar',
                            type: 'string',
                            format: 'uri',
                            nullable: true,
                            example: 'http://api.example.com/storage/avatars/user1.jpg'
                        ),
                        new OA\Property(
                            property: 'phone',
                            type: 'string',
                            nullable: true,
                            example: '+7 (999) 123-45-67'
                        ),
                        new OA\Property(
                            property: 'address',
                            type: 'string',
                            nullable: true,
                            example: 'г. Москва, ул. Примерная, д. 1'
                        ),
                        new OA\Property(
                            property: 'company',
                            type: 'string',
                            nullable: true,
                            example: 'ООО "Рога и копыта"'
                        ),
                    ]
                ),
                new OA\Property(
                    property: 'statistics',
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'total_products',
                            type: 'integer',
                            example: 42
                        ),
                        new OA\Property(
                            property: 'active_products',
                            type: 'integer',
                            example: 35
                        ),
                        new OA\Property(
                            property: 'last_product_created',
                            type: 'string',
                            format: 'date-time',
                            nullable: true,
                            example: '2024-01-19 16:45:00'
                        ),
                    ]
                ),
            ]
        ),
    ]
)]
class UserResourceSchema {}
