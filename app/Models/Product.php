<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Product",
    type: "object",
    title: "Product",
    description: "Товар в каталоге"
)]

class Product extends Model
{

    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    #[OA\Property(
        property: "id",
        description: "Уникальный идентификатор",
        type: "integer",
        readOnly: true,
        example: 145
    )]
    #[OA\Property(
        property: "name",
        description: "Название товара",
        type: "string",
        maxLength: 255,
        example: "Беспроводные наушники Sony WH-1000XM5"
    )]
    #[OA\Property(
        property: "description",
        description: "Описание (может отсутствовать)",
        type: "string",
        nullable: true,
        example: "Шумоподавление, 30 часов работы"
    )]
    #[OA\Property(
        property: "price",
        description: "Цена",
        type: "number",
        format: "float",
        minimum: 0,
        example: 349.99
    )]


    protected $fillable = ['name', 'description', 'price'];
    public function dealItems() {
        return $this->morphMany(DealItem::class, 'item');
    }
}
