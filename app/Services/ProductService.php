<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Получить все продукты
     */
    public function getAllProducts(): Collection
    {
        return $this->productRepository->all();
    }

    /**
     * Получить продукты с пагинацией
     */
    public function getPaginatedProducts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }

    /**
     * Получить продукт по ID
     */
    public function getProductById(int $id): ?object
    {
        return $this->productRepository->find($id);
    }

    /**
     * Создать новый продукт
     */
    public function createProduct(array $data): object
    {
        // Здесь можно добавить дополнительную бизнес-логику, например:
        // - форматирование цены
        // - генерация slug
        // - проверка уникальности названия

        $data['price'] = number_format($data['price'] ?? 0, 2, '.', '');

        return $this->productRepository->create($data);
    }

    /**
     * Обновить продукт
     */
    public function updateProduct(int $id, array $data): bool
    {
        // Можно добавить проверки, очистку данных и т.д.
        if (isset($data['price'])) {
            $data['price'] = number_format($data['price'], 2, '.', '');
        }

        return $this->productRepository->update($id, $data);
    }

    /**
     * Удалить продукт
     */
    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    /**
     * Поиск продукта по названию (пример дополнительного метода)
     */
    public function findProductByName(string $name): ?object
    {
        return $this->productRepository->findByName($name);
    }

    /**
     * Поиск продуктов по части названия
     */
    public function searchProducts(string $query): Collection
    {
        return $this->productRepository->search($query);
    }
}
