<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Вход и получение токена
     */
    #[OA\Post(
        path: "/api/login",
        summary: "Получить Bearer Token",
        description: "Аутентификация пользователя и получение Bearer токена",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешная аутентификация",
                content: new OA\JsonContent(ref: "#/components/schemas/UserWithTokenSuccessResponse")
//                content: new OA\JsonContent(
//                    properties: [
//                        new OA\Property(property: "success", type: "boolean", example: true),
//                        new OA\Property(property: "data", type: "object", properties: [
//                            new OA\Property(property: "token", type: "string", example: "1|randomtoken123"),
//                            new OA\Property(property: "user", type: "object", properties: [
//                                new OA\Property(property: "id", type: "integer", example: 1),
//                                new OA\Property(property: "name", type: "string", example: "John Doe"),
//                                new OA\Property(property: "email", type: "string", example: "user@example.com"),
//                            ]),
//                        ]),
//                        new OA\Property(property: "message", type: "string", example: "Успешный вход"),
//                        new OA\Property(property: "code", type: "integer", example: 200),
//                    ]
//                )
            ),
            new OA\Response(
                response: 401,
                description: "Неверные учетные данные",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Неверные учетные данные'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 'Успешный вход');
    }

    /**
     * Регистрация нового пользователя
     */
    #[OA\Post(
        path: "/api/register",
        summary: "Регистрация нового пользователя",
        description: "Создание нового пользователя и получение Bearer токена",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
//                properties: [
//                    new OA\Property(property: "name", type: "string", example: "John Doe"),
//                    new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
//                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
//                    new OA\Property(property: "password_confirmation", type: "string", format: "password", example: "password123"),
//                ]
                properties: [
                    new OA\Property(property: "success", type: "boolean", example: true),
                    new OA\Property(property: "data", ref: "#/components/schemas/ProductResource"),
                    new OA\Property(property: "message", type: "string", nullable: true),
                    new OA\Property(property: "code", type: "integer", example: 200),
                    ]
)
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Успешная регистрация",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object", properties: [
                            new OA\Property(property: "token", type: "string", example: "1|randomtoken123"),
                            new OA\Property(property: "user", type: "object", properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "name", type: "string", example: "John Doe"),
                                new OA\Property(property: "email", type: "string", example: "user@example.com"),
                            ]),
                        ]),
                        new OA\Property(property: "message", type: "string", example: "Успешная регистрация"),
                        new OA\Property(property: "code", type: "integer", example: 201),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return $this->createdResponse([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 'Успешная регистрация');
    }

    /**
     * Выход (отзыв токена)
     */
    #[OA\Post(
        path: "/api/logout",
        summary: "Выход и отзыв токена",
        description: "Отзывает текущий Bearer токен пользователя",
        security: [["bearerAuth" => []]],
        tags: ["Authentication"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный выход",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Успешный выход"),
                        new OA\Property(property: "code", type: "integer", example: 200),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'Успешный выход');
    }

    /**
     * Получить текущего пользователя
     */
    #[OA\Get(
        path: "/api/user",
        summary: "Получить информацию о текущем пользователе",
        description: "Возвращает информацию о текущем аутентифицированном пользователе",
        security: [["bearerAuth" => []]],
        tags: ["Authentication"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный ответ",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object", properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "name", type: "string", example: "John Doe"),
                            new OA\Property(property: "email", type: "string", example: "user@example.com"),
                            new OA\Property(property: "created_at", type: "string", format: "date-time"),
                            new OA\Property(property: "updated_at", type: "string", format: "date-time"),
                        ]),
                        new OA\Property(property: "message", type: "string", example: "Информация о пользователе"),
                        new OA\Property(property: "code", type: "integer", example: 200),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Не авторизован",
                content: new OA\JsonContent(ref: "#/components/schemas/UnauthorizedError")
            ),
        ]
    )]
    public function user(Request $request)
    {
        return $this->successResponse(
            $request->user(),
            'Информация о пользователе'
        );
    }
}
