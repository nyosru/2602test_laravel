<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: 'UnauthorizedError',
    type: 'object',
    description: 'Ошибка авторизации',
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Unauthorized'
        ),
        new OA\Property(
            property: 'errors',
            type: 'object',
            example: '{}'
        ),
    ]
)]
#[OA\Schema(
    schema: 'ForbiddenError',
    type: 'object',
    description: 'Доступ запрещен',
    properties: [
        new OA\Property(
            property: 'message',
            type: 'string',
            example: 'Forbidden'
        ),
        new OA\Property(
            property: 'errors',
            type: 'object',
            example: '{}'
        ),
    ]
)]

class ErrorSchemas {}
