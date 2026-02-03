<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CreateProductRequest',
    required: ['name', 'price'],
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            example: 'Новый продукт'
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Описание нового продукта'
        ),
        new OA\Property(
            property: 'price',
            type: 'number',
            format: 'float',
            minimum: 0,
            example: 99.99
        ),
    ]
)]
#[OA\Schema(
    schema: 'UpdateProductRequest',
    properties: [
        new OA\Property(
            property: 'name',
            type: 'string',
            maxLength: 255,
            nullable: true,
            example: 'Обновленное название'
        ),
        new OA\Property(
            property: 'description',
            type: 'string',
            nullable: true,
            example: 'Обновленное описание'
        ),
        new OA\Property(
            property: 'price',
            type: 'number',
            format: 'float',
            minimum: 0,
            nullable: true,
            example: 199.99
        ),
    ]
)]
class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ];

        // Для обновления все поля необязательные
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules = [
                'name' => ['sometimes', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'price' => ['sometimes', 'numeric', 'min:0'],
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название продукта обязательно',
            'name.max' => 'Название не должно превышать 255 символов',
            'price.required' => 'Цена обязательна',
            'price.numeric' => 'Цена должна быть числом',
            'price.min' => 'Цена не может быть отрицательной',
        ];
    }
}
