<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders (admin only)
     */
    public function index()
    {
        if (!auth()->guard('admin')->check()) {
            abort(403, 'Non autorisé');
        }

        $orders = Order::with('items.product')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details (admin only)
     */
    public function show(Order $order)
    {
        if (!auth()->guard('admin')->check()) {
            abort(403, 'Non autorisé');
        }

        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status (admin only)
     */
    public function update(Request $request, Order $order)
    {
        if (!auth()->guard('admin')->check()) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Statut mis à jour');
    }

    /**
     * Create an order (public)
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        // Calculate total price
        $totalPrice = 0;
        $items = [];

        foreach ($validated['products'] as $product) {
            $prod = Product::findOrFail($product['id']);
            $totalPrice += $prod->price * $product['quantity'];
            $items[$product['id']] = ['quantity' => $product['quantity'], 'price' => $prod->price];
        }

        // Create order
        $order = Order::create([
            'user_name' => $validated['user_name'],
            'user_email' => $validated['user_email'],
            'user_phone' => $validated['user_phone'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($items as $productId => $item) {
            $order->items()->create([
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // TODO: Send confirmation email

        return redirect()->route('orders.confirmation', $order)->with('success', 'Commande créée avec succès!');
    }

    /**
     * Show order confirmation (public)
     */
    public function confirmation(Order $order)
    {
        $order->load('items.product');
        return view('orders.confirmation', compact('order'));
    }

    /**
     * Delete order (admin only)
     */
    public function destroy(Order $order)
    {
        if (!auth()->guard('admin')->check()) {
            abort(403, 'Non autorisé');
        }

        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée');
    }
}
