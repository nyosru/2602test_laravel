<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API Каталог товаров',
    description: 'Полноценное REST API для работы с продуктами'
)]

#[OA\Server(url: '/', description: 'API')]

#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT',
    description: 'Используйте Bearer Token'
)]

#[OA\Tag(name: 'Products', description: 'Операции с продуктами')]
#[OA\Tag(name: 'Authentication', description: 'Аутентификация и управление пользователями')]

class ApiInfo
{
    // этот класс может быть пустым — важно только наличие атрибутов
}
