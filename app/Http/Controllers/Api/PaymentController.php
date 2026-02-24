<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OpenApi\Attributes as OA;

class PaymentController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Список платежей
     */
    #[OA\Get(
        path: "/api/payments",
        description: "Возвращает список платежей пользователя с пагинацией. По умолчанию используются платежи текущего пользователя.",
        summary: "Получить список платежей",
        tags: ["Payments"],
        parameters: [
            new OA\Parameter(
                name: "user_id",
                description: "ID пользователя, для которого нужно получить платежи. По умолчанию — текущий пользователь.",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", example: 2)
            ),
            new OA\Parameter(
                name: "direction",
                description: "Направление платежей: to — в сторону пользователя, from — от пользователя.",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: ["to", "from"],
                    example: "to"
                )
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Количество элементов на странице (макс. 100)",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 15, maximum: 100)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список платежей успешно получен",
                content: new OA\JsonContent(ref: "#/components/schemas/PaymentsListSuccessResponse")
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
        ]
    )]
    public function index(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ], [
            'user_id.required' => 'ID пользователя обязателен.',
            'user_id.integer' => 'ID пользователя должен быть числом.',
            'user_id.exists' => 'Пользователь не найден в системе.',
        ]);

        $userId = (int) $validated['user_id'];


        $perPage = min((int)$request->get('per_page', 15), 100);
        $direction = $request->get('direction');

        $query = Payment::query()
            ->where('user_id', $userId)
            ->orderByDesc('id');

        if ($direction && in_array($direction, ['to', 'from'], true)) {
            $query->where('direction', $direction);
        }

        $payments = $query->paginate($perPage);

        return $this->paginatedResponse(
            $payments,
            'Список платежей получен успешно'
        );
    }

    /**
     * Получить текущий баланс пользователя
     */
    #[OA\Get(
        path: "/api/payments/balance",
        description: "Публичный эндпоинт. Возвращает текущий баланс пользователя по платежам со статусом completed. Пользователь указывается только по user_id.",
        summary: "Получить текущий баланс пользователя",
        tags: ["Payments"],
        parameters: [
            new OA\Parameter(
                name: "user_id",
                description: "ID пользователя, для которого нужно получить баланс.",
                in: "query",
                required: true,
                schema: new OA\Schema(type: "integer", example: 2)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Баланс успешно получен",
                content: new OA\JsonContent(ref: "#/components/schemas/PaymentBalanceSuccessResponse")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function balance(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $userId = (int) $validated['user_id'];

        $rows = Payment::query()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->selectRaw("
                currency,
                COALESCE(SUM(CASE WHEN direction = 'to' THEN amount ELSE 0 END), 0)
              - COALESCE(SUM(CASE WHEN direction = 'from' THEN amount ELSE 0 END), 0) as balance
            ")
            ->groupBy('currency')
            ->get();

        $balances = $rows->map(static function (Payment $payment) {
            return [
                'currency' => $payment->currency,
                'balance'  => (float) $payment->balance,
            ];
        })->values();

        return $this->successResponse(
            [
                'user_id'  => $userId,
                'balances' => $balances,
            ],
            'Баланс пользователя получен успешно'
        );
    }

    /**
     * Создать платёж
     */
    #[OA\Post(
        path: "/api/payments",
        description: "Создаёт платёж в сторону пользователя или от пользователя. По умолчанию платёж относится к текущему пользователю.",
        summary: "Создать платёж",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["direction", "amount"],
                properties: [
                    new OA\Property(
                        property: "user_id",
                        description: "ID пользователя, к которому относится платёж. Если не указано — используется текущий пользователь.",
                        type: "integer",
                        example: 10,
                        nullable: true
                    ),
                    new OA\Property(
                        property: "direction",
                        description: "Направление платежа: to — в сторону пользователя, from — от пользователя.",
                        type: "string",
                        enum: ["to", "from"],
                        example: "to"
                    ),
                    new OA\Property(
                        property: "amount",
                        description: "Сумма платежа",
                        type: "number",
                        format: "float",
                        example: 1500.50
                    ),
                    new OA\Property(
                        property: "currency",
                        description: "Валюта в формате ISO 4217 (3 символа). По умолчанию RUB.",
                        type: "string",
                        example: "RUB"
                    ),
                    new OA\Property(
                        property: "status",
                        description: "Статус платежа. По умолчанию pending.",
                        type: "string",
                        example: "pending"
                    ),
                    new OA\Property(
                        property: "description",
                        description: "Описание платежа",
                        type: "string",
                        example: "Оплата услуги",
                        nullable: true
                    ),
                ],
                type: "object"
            )
        ),
        tags: ["Payments"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Платеж успешно создан",
                content: new OA\JsonContent(ref: "#/components/schemas/PaymentCreatedResponse")
            ),
            new OA\Response(
                response: 400,
                description: "Ошибка запроса",
                content: new OA\JsonContent(ref: "#/components/schemas/ErrorResponse")
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $authUser = $request->user();

        $validated = $request->validate([
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'direction' => ['required', 'in:to,from'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'currency' => ['nullable', 'string', 'size:3'],
            'status' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $userId = $validated['user_id'] ?? $authUser->id;

        return DB::transaction(function () use ($validated, $userId) {


            // Если деньги списываются от пользователя — проверяем баланс
            if ($validated['direction'] === 'from') {
                $balance = Payment::query()
                    ->where('user_id', $userId)
                    ->where('status', 'completed')
                    ->selectRaw("
                        COALESCE(SUM(CASE WHEN direction = 'to' THEN amount ELSE 0 END), 0)
                      - COALESCE(SUM(CASE WHEN direction = 'from' THEN amount ELSE 0 END), 0) as balance
                    ")
                    ->value('balance');

                if ($balance < $validated['amount']) {
                    return $this->validationErrorResponse([
                        'amount' => ['Недостаточно средств на балансе для списания.'],
                    ]);
                }
            }

            $payment = Payment::create([
                'user_id' => $userId,
                'direction' => $validated['direction'],
                'amount' => $validated['amount'],
                'currency' => $validated['currency'] ?? 'RUB',
                'status' => $validated['status'] ?? 'pending',
                'description' => $validated['description'] ?? null,
            ]);

            return $this->createdResponse(
                $payment,
                'Платеж успешно создан'
            );

        });
    }

    /**
     * Показать один платёж
     */
    #[OA\Get(
        path: "/api/payments/{id}",
        summary: "Получить платёж по ID",
        tags: ["Payments"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID платежа",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Платеж успешно получен",
                content: new OA\JsonContent(ref: "#/components/schemas/PaymentSuccessResponse")
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
            new OA\Response(
                response: 404,
                description: "Платеж не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
        ]
    )]
    public function show(Request $request, Payment $payment): JsonResponse
    {
        return $this->successResponse(
            $payment,
            'Платеж получен успешно'
        );
    }

    /**
     * Обновить платёж
     */
    #[OA\Patch(
        path: "/api/payments/{id}",
        description: "Частичное обновление платежа.",
        summary: "Обновить платёж",
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: "direction",
                        description: "Направление платежа: to — в сторону пользователя, from — от пользователя.",
                        type: "string",
                        enum: ["to", "from"],
                        example: "to"
                    ),
                    new OA\Property(
                        property: "amount",
                        description: "Сумма платежа",
                        type: "number",
                        format: "float",
                        example: 1500.50
                    ),
                    new OA\Property(
                        property: "currency",
                        description: "Валюта в формате ISO 4217 (3 символа).",
                        type: "string",
                        example: "RUB"
                    ),
                    new OA\Property(
                        property: "status",
                        description: "Статус платежа.",
                        type: "string",
                        example: "pending"
                    ),
                    new OA\Property(
                        property: "description",
                        description: "Описание платежа",
                        type: "string",
                        example: "Оплата услуги",
                        nullable: true
                    ),
                ],
                type: "object"
            )
        ),
        tags: ["Payments"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID платежа",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Платеж успешно обновлён",
                content: new OA\JsonContent(ref: "#/components/schemas/PaymentSuccessResponse")
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
            new OA\Response(
                response: 403,
                description: "Доступ к платежу запрещён",
                content: new OA\JsonContent(ref: "#/components/schemas/ForbiddenError")
            ),
            new OA\Response(
                response: 404,
                description: "Платеж не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function update(Request $request, $payment_id): JsonResponse
    {

        try {

        $validated = $request->validate([
            'direction' => ['sometimes', 'in:to,from'],
            'amount' => ['sometimes', 'numeric', 'min:0.01'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'status' => ['sometimes', 'string', 'max:50'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);
            $payment = Payment::findOrFail($payment_id);

            $payment->update($validated);

        return $this->updatedResponse(
            $payment->refresh(),
            'Платеж успешно обновлён'
        );
        }catch (ModelNotFoundException $e){
            return $this->notFoundResponse();
        }
    }

    /**
     * Удалить платёж
     */
    #[OA\Delete(
        path: "/api/payments/{id}",
        summary: "Удалить платёж",
        tags: ["Payments"],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID платежа",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Платеж успешно удалён",
                content: new OA\JsonContent(ref: "#/components/schemas/PaymentDeletedResponse")
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
            new OA\Response(
                response: 404,
                description: "Платеж не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
        ]
    )]
    public function destroy(Request $request, $payment_id ): JsonResponse
    {
        try {
            $payment = Payment::findOrFail($payment_id);
            $payment->delete();
            return $this->deletedResponse('Платеж успешно удалён');
        }catch (ModelNotFoundException $e){
            return $this->notFoundResponse();
        }
    }
}

