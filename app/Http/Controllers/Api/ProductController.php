<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{

    use \App\Traits\ApiResponse;
    protected $repository;


    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;

        $this->middleware('auth:sanctum')->except([
            'indexPublic'
        ]);
    }

    /**
     * Получить список продуктов (публичный доступ)
     */
    #[OA\Get(
        path: "/api/public/products",
        summary: "Получить список продуктов (публичный доступ)",
        description: "Возвращает список продуктов с пагинацией. Без авторизации",
        tags: ["Products"],
        parameters: [
            new OA\Parameter(
                name: "page",
                description: "Номер страницы",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Количество элементов на странице (макс. 100)",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 15, maximum: 100)
            ),
            new OA\Parameter(
                name: "search",
                description: "Поиск по названию или описанию",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "sort_by",
                description: "Поле для сортировки",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: ["id", "name", "price", "created_at"],
                    default: "id"
                )
            ),
            new OA\Parameter(
                name: "sort_order",
                description: "Порядок сортировки",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: ["asc", "desc"],
                    default: "desc"
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список продуктов - успешный ответ",
                content: new OA\JsonContent(ref: "#/components/schemas/ProductsListSuccessResponse")
            )]
    )]
    public function indexPublic(Request $request)
    {
        // Логика аналогичная index(), но без проверки авторизации
        $perPage = min($request->get('per_page', 15), 100);
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $validSortFields = ['id', 'name', 'price', 'created_at'];
        if (in_array($sortBy, $validSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate($perPage);

        return $this->paginatedResponse(
            $products,
            'Список продуктов получен успешно'
        );
    }




    /**
     * Получить список продуктов с пагинацией
     */
    #[OA\Get(
        path: "/api/products",
        summary: "Получить список продуктов",
        description: "Возвращает список продуктов с пагинацией",
        tags: ["Products"],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "page",
                description: "Номер страницы",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            ),
            new OA\Parameter(
                name: "per_page",
                description: "Количество элементов на странице (макс. 100)",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer", default: 15, maximum: 100)
            ),
            new OA\Parameter(
                name: "search",
                description: "Поиск по названию или описанию",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "sort_by",
                description: "Поле для сортировки",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: ["id", "name", "price", "created_at"],
                    default: "id"
                )
            ),
            new OA\Parameter(
                name: "sort_order",
                description: "Порядок сортировки",
                in: "query",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                    enum: ["asc", "desc"],
                    default: "desc"
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный ответ",
//                content: new OA\JsonContent(
//                    properties: [
//                        new OA\Property(
//                            property: "data",
//                            type: "array",
//                            items: new OA\Items(ref: "#/components/schemas/ProductResource")
//                        ),
//                        new OA\Property(
//                            property: "links",
//                            ref: "#/components/schemas/PaginationLinks"
//                        ),
//                        new OA\Property(
//                            property: "meta",
//                            ref: "#/components/schemas/PaginationMeta"
//                        ),
//                    ]
//                )
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", ref: "#/components/schemas/ProductResource"),
                        new OA\Property(property: "message", type: "string", nullable: true),
                        new OA\Property(property: "code", type: "integer", example: 200),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $perPage = min($request->get('per_page', 15), 100);
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Product::query();

        // Поиск
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Сортировка
        $validSortFields = ['id', 'name', 'price', 'created_at'];
        if (in_array($sortBy, $validSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Пагинация и возврат ресурса
        $products = $query->paginate($perPage);

        // ВОТ ГЛАВНОЕ - используем ProductResource::collection()
//        return ProductResource::collection($products);
        return $this->paginatedResponse(
            $products,
            'Список продуктов получен успешно'
        );
    }

    /**
     * Получить один продукт
     */
    #[OA\Get(
        path: "/api/products/{id}",
        summary: "Получить продукт по ID",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID продукта",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Успешный ответ",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", ref: "#/components/schemas/ProductResource"),
                        new OA\Property(property: "message", type: "string", nullable: true),
                        new OA\Property(property: "code", type: "integer", example: 200),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Продукт не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),

        ]
    )]
    public function show(Product $product)
    {
        return new ProductResource($product);
    }





    /**
     * Создать новый продукт
     */
    #[OA\Post(
        path: "/api/products",
        summary: "Создать новый продукт",
        description: "Создает новый продукт и возвращает его данные",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/CreateProductRequest")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Продукт успешно создан",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Продукт успешно создан"),
                        new OA\Property(property: "data", ref: "#/components/schemas/ProductResource"),
                        new OA\Property(property: "code", type: "integer", example: 201),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function store(ProductRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product = $this->repository->create($validated);

//        return response()->json([
//            'message' => 'Продукт успешно создан',
//            'data' => new ProductResource($product),
//        ], 201);
        return $this->createdResponse(
            new ProductResource($product),
            'Продукт успешно создан'
        );
    }

    /**
     * Обновить продукт
     */
    #[OA\Put(
        path: "/api/products/{id}",
        summary: "Обновить продукт",
        description: "Обновляет данные продукта и возвращает обновленный продукт",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID продукта",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/UpdateProductRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Продукт успешно обновлен",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", ref: "#/components/schemas/ProductResource"),
                        new OA\Property(property: "message", type: "string", example: "Продукт успешно обновлен"),
                        new OA\Property(property: "code", type: "integer", example: 200),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Продукт не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    #[OA\Patch(
        path: "/api/products/{id}",
        summary: "Частично обновить продукт",
        description: "Частично обновляет данные продукта",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID продукта",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/UpdateProductRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Продукт успешно обновлен",
                content: new OA\JsonContent(ref: "#/components/schemas/ProductResource")
            ),
            new OA\Response(
                response: 404,
                description: "Продукт не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
            new OA\Response(
                response: 422,
                description: "Ошибка валидации",
                content: new OA\JsonContent(ref: "#/components/schemas/ValidationError")
            ),
        ]
    )]
    public function update(ProductRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();
        $product = $this->repository->updateOrFail($id, $validated);

        return $this->successResponse(
            new ProductResource($product->fresh()),
            'Продукт успешно обновлен'
        );
    }

    /**
     * Удалить продукт (мягкое удаление)
     */
    #[OA\Delete(
        path: "/api/products/{id}",
        summary: "Удалить продукт",
        description: "Выполняет мягкое удаление продукта",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID продукта",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Продукт успешно удален",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object", nullable: true),
                        new OA\Property(property: "message", type: "string", example: "Продукт успешно удален"),
                        new OA\Property(property: "code", type: "integer", example: 200),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Продукт не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
        ]
    )]
    public function destroy(Product $product): JsonResponse
    {
//        $product = $this->repository->findOrFail($id);
//        $this->repository->delete($id);
        $product->delete();

        return $this->successResponse(
            new ProductResource($product),
            'Продукт успешно удален'
        );
    }

    /**
     * Восстановить удаленный продукт
     */
    #[OA\Post(
        path: "/api/products/{id}/restore",
        summary: "Восстановить удаленный продукт",
        description: "Восстанавливает мягко удаленный продукт",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID продукта",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Продукт успешно восстановлен",
                content: new OA\JsonContent(ref: "#/components/schemas/ProductResource")
            ),
            new OA\Response(
                response: 404,
                description: "Продукт не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
        ]
    )]
    public function restore(int $id): JsonResponse
    {
        $this->repository->restore($id);
        $product = $this->repository->findOrFail($id);

        return response()->json([
            'message' => 'Продукт успешно восстановлен',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Полное удаление продукта
     */
    #[OA\Delete(
        path: "/api/products/{id}/force",
        summary: "Полное удаление продукта",
        description: "Полностью удаляет продукт из базы данных (включая мягко удаленные)",
        tags: ["Products"],
         security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                description: "ID продукта",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Продукт полностью удален",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'message', type: 'string'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Продукт не найден",
                content: new OA\JsonContent(ref: "#/components/schemas/NotFoundError")
            ),
        ]
    )]
    public function forceDestroy(int $id): JsonResponse
    {
        $this->repository->forceDelete($id);

        return response()->json([
            'message' => 'Продукт полностью удален из базы данных',
        ]);
    }

}


//namespace App\Http\Controllers\Api;
//
//use App\Http\Controllers\Controller;
//use App\Http\Resources\ProductCollection;
//use App\Services\ProductService;
//use Illuminate\Http\Request;
//use Illuminate\Http\JsonResponse;
//use Illuminate\Http\Response;
//
//class ProductController extends Controller
//{
//    protected ProductService $service;
//
//    public function __construct(ProductService $service)
//    {
//        $this->service = $service;
//    }
//
//    public function index(): JsonResponse
//    {
//        $products = $this->service->getAllProducts();
////        dd($products);
////        return response()->json($products);
//        return response()->json(new ProductCollection($products));
//    }
//
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
//}
