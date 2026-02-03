<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;


class ProductCollection extends ResourceCollection
{

    public array $data;

    public array $meta;


    public array $links;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => ProductResource::collection($this->collection),

            'links' => $this->getLinks(),

            'meta' => $this->getMeta(),
        ];
    }


    /**
     * Получить ссылки пагинации
     */
    protected function getLinks(): array
    {
        return [
//            'first' => $this->url(1),
//            'last' => $this->url($this->lastPage()),
//            'prev' => $this->previousPageUrl(),
//            'next' => $this->nextPageUrl(),
        ];
    }

    /**
     * Получить мета-данные пагинации
     */
    protected function getMeta(): array
    {
        return [
            'current_page' => $this->currentPage(),
            'from' => $this->firstItem(),
            'to' => $this->lastItem(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
            'last_page' => $this->lastPage(),

            // Дополнительные мета-данные
            'has_more_pages' => $this->hasMorePages(),
            'on_first_page' => $this->onFirstPage(),
            'on_last_page' => $this->onLastPage(),

            // Ссылки для каждой страницы (опционально)
            'links' => $this->linkCollection()->toArray(),
        ];
    }

    /**
     * Дополнительные данные в ответе
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toDateTimeString(),
                'query_time' => microtime(true) - LARAVEL_START,
            ],
        ];
    }

}
