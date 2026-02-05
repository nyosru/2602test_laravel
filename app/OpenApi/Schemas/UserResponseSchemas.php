<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с пользователем',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserWithTokenSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с пользователем и токеном',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserWithTokenResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь с токеном получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserCreatedResponse',
    type: 'object',
    description: 'Пользователь успешно создан',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь успешно создан'),
        new OA\Property(property: 'code', type: 'integer', example: 201),
    ]
)]
#[OA\Schema(
    schema: 'UserWithTokenCreatedResponse',
    type: 'object',
    description: 'Пользователь успешно создан с токеном',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserWithTokenResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь успешно создан'),
        new OA\Property(property: 'code', type: 'integer', example: 201),
    ]
)]
#[OA\Schema(
    schema: 'UserUpdatedResponse',
    type: 'object',
    description: 'Пользователь успешно обновлен',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь успешно обновлен'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserDeletedResponse',
    type: 'object',
    description: 'Пользователь успешно удален',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object', nullable: true),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь успешно удален'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserListSuccessResponse',
    type: 'object',
    description: 'Успешный ответ со списком пользователей',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserCollection'),
        new OA\Property(property: 'message', type: 'string', example: 'Список пользователей получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserProfileSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с профилем пользователя',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserProfileResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Профиль пользователя получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserWithTokensSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с пользователем и его токенами',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/UserWithTokensResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Пользователь с токенами получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'CurrentUserWithTokenInfoResponse',
    type: 'object',
    description: 'Текущий пользователь с информацией о токене',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/CurrentUserWithTokenInfo'),
        new OA\Property(property: 'message', type: 'string', example: 'Информация о токене получена'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserStatisticsResponse',
    type: 'object',
    description: 'Статистика пользователей',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(
            property: 'data',
            type: 'object',
            properties: [
                new OA\Property(property: 'total_users', type: 'integer', example: 150),
                new OA\Property(property: 'active_users', type: 'integer', example: 120),
                new OA\Property(property: 'admin_users', type: 'integer', example: 5),
                new OA\Property(property: 'new_users_today', type: 'integer', example: 3),
                new OA\Property(property: 'new_users_this_week', type: 'integer', example: 15),
                new OA\Property(property: 'new_users_this_month', type: 'integer', example: 42),
                new OA\Property(
                    property: 'activity',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'last_24_hours', type: 'integer', example: 45),
                        new OA\Property(property: 'last_7_days', type: 'integer', example: 210),
                        new OA\Property(property: 'last_30_days', type: 'integer', example: 850),
                    ]
                ),
            ]
        ),
        new OA\Property(property: 'message', type: 'string', example: 'Статистика пользователей получена'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserTokenCreatedResponse',
    type: 'object',
    description: 'Токен успешно создан',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(
            property: 'data',
            type: 'object',
            properties: [
                new OA\Property(property: 'token', type: 'string', example: '7|newtoken1234567890'),
                new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                new OA\Property(property: 'expires_at', type: 'string', format: 'date-time', nullable: true),
                new OA\Property(property: 'abilities', type: 'array', items: new OA\Items(type: 'string')),
            ]
        ),
        new OA\Property(property: 'message', type: 'string', example: 'Токен успешно создан'),
        new OA\Property(property: 'code', type: 'integer', example: 201),
    ]
)]
#[OA\Schema(
    schema: 'UserLogoutResponse',
    type: 'object',
    description: 'Успешный выход из системы',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object', nullable: true),
        new OA\Property(property: 'message', type: 'string', example: 'Успешный выход из системы'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'UserPasswordChangedResponse',
    type: 'object',
    description: 'Пароль успешно изменен',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object', nullable: true),
        new OA\Property(property: 'message', type: 'string', example: 'Пароль успешно изменен'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
class UserResponseSchemas {}
