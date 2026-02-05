<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at?->toDateTimeString(),
            'is_admin' => (bool) $this->is_admin,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            // Условные поля
            'avatar' => $this->when($this->avatar, $this->avatar),
            'phone' => $this->when($this->phone, $this->phone),
            'company' => $this->when($this->company, $this->company),

//            'links' => [
//                'self' => route('api.user.show', $this->id),
//                'products' => route('api.user.products', $this->id),
//                'tokens' => route('api.user.tokens', $this->id),
//                'update' => route('api.user.update', $this->id),
//                'delete' => route('api.user.destroy', $this->id),
//            ],

            // Мета-данные
            'meta' => [
                'products_count' => $this->whenLoaded('products', fn() => $this->products->count()),
                'tokens_count' => $this->whenLoaded('tokens', fn() => $this->tokens->count()),
                'last_login' => $this->when($this->last_login, fn() => $this->last_login?->toDateTimeString()),
            ],
        ];
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
            ],
        ];
    }
}
