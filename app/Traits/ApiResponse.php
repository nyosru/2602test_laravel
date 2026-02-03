<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Успешный ответ
     */
    protected function successResponse($data = null, string $message = null, int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ];

        // Удаляем null значения
        $response = array_filter($response, function ($value) {
            return !is_null($value);
        });

        return response()->json($response, $code);
    }

    /**
     * Ответ с ошибкой
     */
    protected function errorResponse(string $message = null, array $errors = [], int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? 'Произошла ошибка',
            'errors' => $errors,
            'code' => $code,
        ], $code);
    }

    /**
     * Ответ с валидационной ошибкой
     */
    protected function validationErrorResponse(array $errors, string $message = null): JsonResponse
    {
        return $this->errorResponse(
            message: $message ?? 'Ошибка валидации',
            errors: $errors,
            code: 422
        );
    }

    /**
     * Ответ "Не найдено"
     */
    protected function notFoundResponse(string $message = null): JsonResponse
    {
        return $this->errorResponse(
            message: $message ?? 'Ресурс не найден',
            code: 404
        );
    }

    /**
     * Ответ "Запрещено"
     */
    protected function forbiddenResponse(string $message = null): JsonResponse
    {
        return $this->errorResponse(
            message: $message ?? 'Доступ запрещен',
            code: 403
        );
    }

    /**
     * Ответ "Не авторизован"
     */
    protected function unauthorizedResponse(string $message = null): JsonResponse
    {
        return $this->errorResponse(
            message: $message ?? 'Не авторизован',
            code: 401
        );
    }

    /**
     * Ответ с созданием ресурса
     */
    protected function createdResponse($data = null, string $message = null): JsonResponse
    {
        return $this->successResponse(
            data: $data,
            message: $message ?? 'Ресурс успешно создан',
            code: 201
        );
    }

    /**
     * Ответ с обновлением ресурса
     */
    protected function updatedResponse($data = null, string $message = null): JsonResponse
    {
        return $this->successResponse(
            data: $data,
            message: $message ?? 'Ресурс успешно обновлен',
            code: 200
        );
    }

    /**
     * Ответ с удалением ресурса
     */
    protected function deletedResponse(string $message = null): JsonResponse
    {
        return $this->successResponse(
            message: $message ?? 'Ресурс успешно удален',
            code: 200
        );
    }

    /**
     * Ответ с пагинацией
     */
    protected function paginatedResponse($paginator, string $message = null): JsonResponse
    {
        $data = [
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'count' => $paginator->count(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
                'links' => [
                    'first' => $paginator->url(1),
                    'last' => $paginator->url($paginator->lastPage()),
                    'prev' => $paginator->previousPageUrl(),
                    'next' => $paginator->nextPageUrl(),
                ],
            ],
        ];

        return $this->successResponse(
            data: $data,
            message: $message
        );
    }
}
