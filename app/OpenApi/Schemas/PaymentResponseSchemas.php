<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PaymentResource',
    type: 'object',
    description: 'Платёж пользователя',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'user_id', type: 'integer', example: 10),
        new OA\Property(
            property: 'direction',
            type: 'string',
            enum: ['to', 'from'],
            description: 'Направление платежа относительно пользователя: to — в сторону пользователя, from — от пользователя',
            example: 'to'
        ),
        new OA\Property(property: 'amount', type: 'number', format: 'float', example: 1500.50),
        new OA\Property(property: 'currency', type: 'string', example: 'RUB'),
        new OA\Property(property: 'status', type: 'string', example: 'pending'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Оплата услуги'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]
#[OA\Schema(
    schema: 'PaginatedPaymentResponse',
    type: 'object',
    description: 'Пагинированный список платежей',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/PaymentResource')
        ),
        new OA\Property(
            property: 'pagination',
            type: 'object',
            properties: [
                new OA\Property(property: 'total', type: 'integer', example: 50),
                new OA\Property(property: 'count', type: 'integer', example: 15),
                new OA\Property(property: 'per_page', type: 'integer', example: 15),
                new OA\Property(property: 'current_page', type: 'integer', example: 1),
                new OA\Property(property: 'total_pages', type: 'integer', example: 4),
                new OA\Property(
                    property: 'links',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'first', type: 'string', nullable: true),
                        new OA\Property(property: 'last', type: 'string', nullable: true),
                        new OA\Property(property: 'prev', type: 'string', nullable: true),
                        new OA\Property(property: 'next', type: 'string', nullable: true),
                    ]
                ),
            ]
        ),
    ]
)]
#[OA\Schema(
    schema: 'PaymentSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с платежом',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/PaymentResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Платеж получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'PaymentsListSuccessResponse',
    type: 'object',
    description: 'Успешный ответ со списком платежей',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/PaginatedPaymentResponse'),
        new OA\Property(property: 'message', type: 'string', example: 'Список платежей получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'PaymentCreatedResponse',
    type: 'object',
    description: 'Платеж успешно создан',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/PaymentResource'),
        new OA\Property(property: 'message', type: 'string', example: 'Платеж успешно создан'),
        new OA\Property(property: 'code', type: 'integer', example: 201),
    ]
)]
#[OA\Schema(
    schema: 'BalanceByCurrencyResource',
    type: 'object',
    description: 'Баланс в конкретной валюте',
    properties: [
        new OA\Property(property: 'currency', type: 'string', example: 'RUB'),
        new OA\Property(property: 'balance', type: 'number', format: 'float', example: 12500.50),
    ]
)]
#[OA\Schema(
    schema: 'PaymentBalanceData',
    type: 'object',
    description: 'Данные баланса пользователя',
    properties: [
        new OA\Property(property: 'user_id', type: 'integer', example: 10),
        new OA\Property(
            property: 'balances',
            type: 'array',
            description: 'Список балансов по валютам',
            items: new OA\Items(ref: '#/components/schemas/BalanceByCurrencyResource')
        ),
    ]
)]
#[OA\Schema(
    schema: 'PaymentBalanceSuccessResponse',
    type: 'object',
    description: 'Успешный ответ с балансом пользователя',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'data', ref: '#/components/schemas/PaymentBalanceData'),
        new OA\Property(property: 'message', type: 'string', example: 'Баланс пользователя получен успешно'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
#[OA\Schema(
    schema: 'PaymentDeletedResponse',
    type: 'object',
    description: 'Платеж успешно удалён',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', example: 'Платеж успешно удалён'),
        new OA\Property(property: 'code', type: 'integer', example: 200),
    ]
)]
class PaymentResponseSchemas
{
}
