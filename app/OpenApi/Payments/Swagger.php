<?php

namespace App\OpenApi\Payments;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Payments API',
    description: 'API для просмотра баланса и управления платежами пользователей'
)]
#[OA\Server(
    url: '/',
    description: 'Payments API',
)]
#[OA\Tag(name: 'Payments', description: 'Операции с платежами и балансом')]
class Swagger
{
    public function __invoke(): void
    {
    }
}
