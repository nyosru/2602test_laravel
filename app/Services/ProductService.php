<?php

namespace App\Services;

use App\Repositories\ProductRepository;
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
    public function getPaginatedProducts(int $perPage = 15): LengthAwarePaginator
    {
        return $this->productRepository->paginate($perPage);
    }

    public function getProductById(int $id): ?object
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(array $data): object
    {
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data): bool
    {
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    public function searchProducts(string $query): Collection
    {
        return $this->productRepository->search($query);
    }
}
