<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWithTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userData = (new UserResource($this->resource))->toArray($request);

        return array_merge($userData, [
            'token' => $this->when($this->token, $this->token),
            'token_type' => 'Bearer',
            'token_expires_at' => $this->when($this->token_expires_at,
                fn() => $this->token_expires_at?->toDateTimeString()
            ),
        ]);
    }

    /**
     * Добавить дополнительные данные в ответ
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTimeString(),
                'instructions' => 'Используйте токен в заголовке Authorization: Bearer {token}',
            ],
        ];
    }
}
