<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API Каталог товаров',
    description: 'Полноценное REST API для работы с продуктами'
)]
#[OA\Server(url: 'https://lara2602.local', description: 'Local')]
#[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer')]





class ApiInfo
{
    // этот класс может быть пустым — важно только наличие атрибутов
}

