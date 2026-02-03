<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $products = $this->service->getAllProducts();
        return response()->json($products);
    }

    public function show(int $id): JsonResponse
    {
        $product = $this->service->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $product = $this->service->createProduct($validated);

        return response()->json($product, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric|min:0',
        ]);

        $updated = $this->service->updateProduct($id, $validated);

        if (!$updated) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product updated']);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->deleteProduct($id);

        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product deleted'], 200);
    }

    public function searchByName(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $products = $this->service->searchProducts($query);

        return response()->json($products);
    }
}
