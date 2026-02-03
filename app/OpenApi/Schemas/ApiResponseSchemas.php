<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ApiResponse',
    type: 'object',
    description: 'Базовый формат ответа API',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object', nullable: true),
        new OA\Property(property: 'message', type: 'string', nullable: true),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'SuccessResponse',
    type: 'object',
    description: 'Успешный ответ',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', type: 'object'),
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'ErrorResponse',
    type: 'object',
    description: 'Ответ с ошибкой',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'data', type: 'object', nullable: true),
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'errors', type: 'object', nullable: true),
        new OA\Property(property: 'code', type: 'integer', example: 400),
    ]
)]
#[OA\Schema(
    schema: 'ValidationError',
    type: 'object',
    description: 'Ошибка валидации',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Ошибка валидации'),
        new OA\Property(
            property: 'errors',
            type: 'object',
            additionalProperties: new OA\AdditionalProperties(
                type: 'array',
                items: new OA\Items(type: 'string')
            )
        ),
        new OA\Property(property: 'code', type: 'integer', example: 422),
    ]
)]
#[OA\Schema(
    schema: 'NotFoundError',
    type: 'object',
    description: 'Ресурс не найден',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Ресурс не найден'),
        new OA\Property(property: 'errors', type: 'object', example: '{}'),
        new OA\Property(property: 'code', type: 'integer', example: 404),
    ]
)]
#[OA\Schema(
    schema: 'ServerError',
    type: 'object',
    description: 'Внутренняя ошибка сервера',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Внутренняя ошибка сервера'),
        new OA\Property(property: 'errors', type: 'object', example: '{}'),
        new OA\Property(property: 'code', type: 'integer', example: 500),
    ]
)]
class ApiResponseSchemas {}
