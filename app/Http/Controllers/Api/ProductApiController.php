<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductApiController extends Controller
{
    /**
     * GET /api/v1/products
     */
    public function index(): JsonResponse
    {
        $products = Product::where('published', true)
            ->with('admin')
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($products);
    }

    /**
     * GET /api/v1/products/{product}
     */
    public function show(Product $product): JsonResponse
    {
        if (!$product->published) {
            abort(404);
        }

        $product->load('admin');
        return response()->json($product);
    }

    /**
     * POST /api/v1/products
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create([
            ...$request->validated(),
            'admin_id' => auth()->guard('admin')->id(),
        ]);

        return response()->json($product, 201);
    }

    /**
     * PUT /api/v1/products/{product}
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());
        return response()->json($product);
    }

    /**
     * DELETE /api/v1/products/{product}
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted'], 200);
    }
}
