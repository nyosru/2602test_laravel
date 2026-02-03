<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

//#[OA\Tag(
//    name: 'Products',
//    description: 'Управление товарами в каталоге'
//)]

class ProductController extends Controller
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

//    /**
//     * Получить список продуктов с пагинацией
//     */
//    #[OA\Get(
//        path: "/api/products",
//        summary: "Получить список продуктов",
//        description: "Возвращает список продуктов с пагинацией",
//        tags: ["Products"],
//        parameters: [
//            new OA\Parameter(
//                name: "page",
//                description: "Номер страницы",
//                in: "query",
//                required: false,
//                schema: new OA\Schema(type: "integer", default: 1)
//            ),
//            new OA\Parameter(
//                name: "per_page",
//                description: "Количество элементов на странице (макс. 100)",
//                in: "query",
//                required: false,
//                schema: new OA\Schema(type: "integer", default: 15, maximum: 100)
//            ),
//            new OA\Parameter(
//                name: "search",
//                description: "Поиск по названию или описанию",
//                in: "query",
//                required: false,
//                schema: new OA\Schema(type: "string")
//            ),
//            new OA\Parameter(
//                name: "sort_by",
//                description: "Поле для сортировки",
//                in: "query",
//                required: false,
//                schema: new OA\Schema(
//                    type: "string",
//                    enum: ["id", "name", "price", "created_at"],
//                    default: "id"
//                )
//            ),
//            new OA\Parameter(
//                name: "sort_order",
//                description: "Порядок сортировки",
//                in: "query",
//                required: false,
//                schema: new OA\Schema(
//                    type: "string",
//                    enum: ["asc", "desc"],
//                    default: "desc"
//                )
//            ),
//        ],
//        responses: [
//            new OA\Response(
//                response: 200,
//                description: "Успешный ответ",
//                content: new OA\JsonContent(ref: "#/components/schemas/ProductCollection")
//            ),
//            new OA\Response(
//                response: 400,
//                description: "Неверные параметры запроса"
//            ),
//            new OA\Response(
//                response: 500,
//                description: "Внутренняя ошибка сервера"
//            ),
//        ]
//    )]
////    public function index(): JsonResponse
////    {
////        $products = $this->service->getAllProducts();
////        return response()->json(new ProductCollection($products));
////    }
//    public function index(Request $request): JsonResponse
//    {
//        $perPage = min($request->get('per_page', 15), 100);
//        $search = $request->get('search');
//        $sortBy = $request->get('sort_by', 'id');
//        $sortOrder = $request->get('sort_order', 'desc');
//
//        $query = Product::query();
//
//        if ($search) {
//            $query->where(function ($q) use ($search) {
//                $q->where('name', 'like', "%{$search}%")
//                    ->orWhere('description', 'like', "%{$search}%");
//            });
//        }
//
//        $validSortFields = ['id', 'name', 'price', 'created_at'];
//        if (in_array($sortBy, $validSortFields)) {
//            $query->orderBy($sortBy, $sortOrder);
//        }
//
//        $products = $query->paginate($perPage);
//
//        // Используем ResourceCollection с помощью ::collection()
////        return ProductResource::collection($products);
////        return response()->json( new ProductResource($products) );
//        return response()->json( new ProductResource::collection($products) );
//
//    }
//
//
//
//    #[OA\Get(
//        path: '/api/products/{id}',
//        summary: 'Получить товар по ID',
//        tags: ['Products'],
//        parameters: [
//            new OA\Parameter(
//                name: 'id',
//                description: 'ID товара',
//                in: 'path',
//                required: true,
//                schema: new OA\Schema(type: 'integer')
//            )
//        ],
//        responses: [
//            new OA\Response(
//                response: 200,
//                description: 'Товар найден',
//                content: new OA\JsonContent(ref: '#/components/schemas/Product')
//            ),
//            new OA\Response(
//                response: 404,
//                description: 'Товар не найден'
//            )
//        ]
//    )]
//    public function show(int $id): JsonResponse
//    {
//        $product = $this->service->getProductById($id);
//
//        if (!$product) {
//            return response()->json(['message' => 'Product not found'], 404);
//        }
//
//        return response()->json($product);
//    }
//
//
//    #[OA\Post(
//        path: '/api/products',
//        summary: 'Создать новый товар',
//        tags: ['Products'],
//        requestBody: new OA\RequestBody(
//            required: true,
//            content: new OA\JsonContent(
//                required: ['name', 'price'],
//                properties: [
//                    new OA\Property(property: 'name', type: 'string', maxLength: 255),
//                    new OA\Property(property: 'description', type: 'string', nullable: true),
//                    new OA\Property(property: 'price', type: 'number', minimum: 0),
//                ]
//            )
//        ),
//        responses: [
//            new OA\Response(
//                response: 201,
//                description: 'Товар создан',
//                content: new OA\JsonContent(ref: '#/components/schemas/Product')
//            )
//        ]
//    )]
//    public function store(Request $request): JsonResponse
//    {
//        $validated = $request->validate([
//            'name'        => 'required|string|max:255',
//            'description' => 'nullable|string',
//            'price'       => 'required|numeric|min:0',
//        ]);
//
//        $product = $this->service->createProduct($validated);
//
//        return response()->json($product, 201);
//    }
//
//    public function update(Request $request, int $id): JsonResponse
//    {
//        $validated = $request->validate([
//            'name'        => 'sometimes|required|string|max:255',
//            'description' => 'nullable|string',
//            'price'       => 'sometimes|required|numeric|min:0',
//        ]);
//
//        $updated = $this->service->updateProduct($id, $validated);
//
//        if (!$updated) {
//            return response()->json(['message' => 'Product not found'], 404);
//        }
//
//        return response()->json(['message' => 'Product updated']);
//    }
//
//    public function destroy(int $id): JsonResponse
//    {
//        $deleted = $this->service->deleteProduct($id);
//
//        if (!$deleted) {
//            return response()->json(['message' => 'Product not found'], 404);
//        }
//
//        return response()->json(['message' => 'Product deleted'], 200);
//    }
//
//    public function searchByName(Request $request): JsonResponse
//    {
//        $query = $request->input('q', '');
//        $products = $this->service->searchProducts($query);
//
//        return response()->json($products);
//    }
}
