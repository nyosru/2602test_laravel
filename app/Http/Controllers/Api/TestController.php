<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

class TestController
{
    use \App\Traits\ApiResponse;

    /**
     * Получить случайного пользователя (без создания токена)
     */
    public function getRandomUser(): JsonResponse
    {
        $user = User::inRandomOrder()->first();

        if (!$user) {
            return $this->notFoundResponse('Пользователи не найдены');
        }

        return $this->successResponse(
            new UserResource($user),
            "Случайный пользователь #{$user->id}"
        );
    }


    /**
     * Получить случайный токен
     */

    #[OA\Get(
        path: "/api/users/random/token",
        summary: "Получить случайный токен (для теста и быстрого получения токена)",
        description: "Возвращает случайный рабочий токен авторизации",
        tags: ["Users"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный ответ",
                content: new OA\JsonContent(ref: "#/components/schemas/UserResource")
            ),
            new OA\Response(
                response: 404,
                description: "Пользователи не найдены",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
        ]
    )]
    public function getRandomToken(): JsonResponse
    {
        $user = User::inRandomOrder()->first();
        if (!$user) {
            return $this->notFoundResponse('Пользователи не найдены');
        }
        $token = $user->createToken('random-user')->plainTextToken;
        return response()->json( ['token' => $token ]);
    }

}
