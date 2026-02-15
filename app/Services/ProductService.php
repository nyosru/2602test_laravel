<?php

namespace App\Services;

use App\DTOs\Product\CreateProductDTO;
use App\DTOs\Product\ProductDTO;
use App\DTOs\Product\UpdateProductDTO;
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
//        return $this->productRepository->find($id);
        $product = $this->productRepository->find($id);
        return $product ? ProductDTO::fromModel($product) : null;
    }

//    public function createProduct(array $data): object
    public function createProduct(CreateProductDTO $dto): ProductDTO
    {
//        return $this->productRepository->create($data);
        $product = $this->productRepository->create($dto->toArray());
        return ProductDTO::fromModel($product);
    }

//    public function updateProduct(int $id, array $data): bool
//    {
//        return $this->productRepository->update($id, $data);
//    }
    public function updateProduct(UpdateProductDTO $dto): ?ProductDTO
    {
        $product = $this->productRepository->update($dto->id, $dto->toArray());
        return $product ? ProductDTO::fromModel($product) : null;
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
