<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Список исключений, которые не должны логироваться
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Преобразуем исключения в JSON ответы
     */
    public function render($request, Throwable $exception)
    {
        // Для API запросов возвращаем JSON
        if ($request->expectsJson()) {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Обработка исключений для API
     */
    protected function handleApiException(Request $request, Throwable $exception): JsonResponse
    {
        // Обработка валидации
        if ($exception instanceof ValidationException) {
            return $this->validationError($exception);
        }

        // Обработка "Не найдено"
        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return $this->notFoundError($exception);
        }

        // Обработка "Метод не разрешен"
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->methodNotAllowedError($exception);
        }

        // Обработка HTTP исключений
        if ($exception instanceof HttpException) {
            return $this->httpError($exception);
        }

        // Обработка аутентификации
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticatedError($exception);
        }

        // Все остальные исключения
        return $this->serverError($exception);
    }

    /**
     * Ошибка валидации
     */
    protected function validationError(ValidationException $exception): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $exception->getMessage(),
            'errors' => $exception->errors(),
            'code' => 422,
        ], 422);
    }

    /**
     * Ресурс не найден
     */
    protected function notFoundError(Exception $exception): JsonResponse
    {
        $message = $exception->getMessage() ?: 'Ресурс не найден';

        // Для ModelNotFoundException можно получить название модели
        if ($exception instanceof ModelNotFoundException) {
            $model = $exception->getModel();
            $modelName = class_basename($model);
            $message = "$modelName не найден";
        }

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => [],
            'code' => 404,
        ], 404);
    }

    /**
     * Метод не разрешен
     */
    protected function methodNotAllowedError(MethodNotAllowedHttpException $exception): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Метод не разрешен',
            'errors' => [
                'method' => [$exception->getMessage()]
            ],
            'code' => 405,
        ], 405);
    }

    /**
     * HTTP ошибки
     */
    protected function httpError(HttpException $exception): JsonResponse
    {
        $statusCode = $exception->getStatusCode();
        $message = $exception->getMessage() ?: 'Ошибка запроса';

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => [],
            'code' => $statusCode,
        ], $statusCode);
    }

    /**
     * Не авторизован
     */
    protected function unauthenticatedError(AuthenticationException $exception): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Не авторизован',
            'errors' => [],
            'code' => 401,
        ], 401);
    }

    /**
     * Серверная ошибка
     */
    protected function serverError(Throwable $exception): JsonResponse
    {
        $message = config('app.debug')
            ? $exception->getMessage()
            : 'Внутренняя ошибка сервера';

        $data = [
            'success' => false,
            'message' => $message,
            'errors' => [],
            'code' => 500,
        ];

        // В режиме отладки добавляем детали ошибки
        if (config('app.debug')) {
            $data['debug'] = [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ];
        }

        return response()->json($data, 500);
    }
}
