<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => (float) $this->price,           // всегда число, а не строка
            'price_formatted' => number_format($this->price, 2, '.', ' '), // для отображения
            'created_at'  => $this->created_at?->toDateTimeString(),
            'updated_at'  => $this->updated_at?->toDateTimeString(),

            // Можно добавить дополнительные поля, если нужно
            // 'slug'        => $this->slug,
            // 'stock'       => $this->stock,
            // 'is_active'   => (bool) $this->is_active,

            // Пример условных полей
            'links' => [
                'self' => route('products.show', $this->id),
            ],
        ];
    }
}
