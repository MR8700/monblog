<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * GET /api/v1/orders (Admin only)
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['items.product', 'admin'])
            ->latest()
            ->paginate(20);

        return response()->json($orders);
    }

    /**
     * GET /api/v1/orders/{order} (Admin only)
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['items.product', 'admin']);
        return response()->json($order);
    }

    /**
     * POST /api/v1/orders (Public)
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $totalPrice = 0;
        $items = [];

        foreach ($validated['products'] as $product) {
            $prod = \App\Models\Product::findOrFail($product['id']);
            $totalPrice += $prod->price * $product['quantity'];
            $items[$product['id']] = ['quantity' => $product['quantity'], 'price' => $prod->price];
        }

        $order = Order::create([
            'user_name' => $validated['user_name'],
            'user_email' => $validated['user_email'],
            'user_phone' => $validated['user_phone'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        foreach ($items as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json($order->load('items'), 201);
    }

    /**
     * PUT /api/v1/orders/{order} (Admin only)
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);
        return response()->json($order);
    }

    /**
     * DELETE /api/v1/orders/{order} (Admin only)
     */
    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted'], 200);
    }

    /**
     * GET /api/v1/orders/{order}/confirmation (Public)
     */
    public function confirmation(Order $order): JsonResponse
    {
        $order->load('items.product');
        return response()->json($order);
    }
}
