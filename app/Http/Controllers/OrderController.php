<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Post;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders (admin only)
     */
    public function index(Request $request)
    {
        if (!auth()->guard('admin')->check()) {
            abort(403, 'Non autorisé');
        }

        $orders = Order::with('items.product', 'items.post')
            ->filter($request->all())
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

        $order->load('items.product', 'items.post');
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
     * Create an order (public) and redirect to payment
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        // Calculate total price
        $totalPrice = 0;
        $items = [];

        foreach ($validated['products'] as $productData) {
            $type = $productData['type'] ?? 'product';
            if ($type === 'post') {
                $item = Post::findOrFail($productData['id']);
            } else {
                $item = Product::findOrFail($productData['id']);
            }
            
            $totalPrice += $item->price * $productData['quantity'];
            $items[] = [
                'id' => $productData['id'],
                'type' => $type,
                'quantity' => $productData['quantity'],
                'price' => $item->price
            ];
        }

        // Create order
        $order = Order::create([
            'user_name' => $validated['user_name'],
            'user_email' => $validated['user_email'],
            'user_phone' => $validated['user_phone'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => Order::STATUS_UNPAID,
        ]);

        // Create order items
        foreach ($items as $itemData) {
            $order->items()->create([
                'product_id' => $itemData['type'] === 'product' ? $itemData['id'] : null,
                'post_id' => $itemData['type'] === 'post' ? $itemData['id'] : null,
                'quantity' => $itemData['quantity'],
                'price' => $itemData['price'],
            ]);
        }

        return redirect()->route('orders.payment.select', ['order' => $order->publicRouteParameter()]);
    }

    /**
     * Show payment method selection
     */
    public function selectPaymentMethod(Order $order)
    {
        if ($order->payment_status === Order::STATUS_PAID) {
            return redirect()->route('orders.confirmation', ['order' => $order->publicRouteParameter()]);
        }

        return view('orders.payment_select', compact('order'));
    }

    /**
     * Handle payment method selection and initiate payment
     */
    public function initiatePayment(Request $request, Order $order, \App\Services\Payment\PaymentGateway $gateway)
    {
        $request->validate(['payment_method' => 'required|in:orange_money,visa,ligdicash']);
        
        $method = $request->payment_method;

        if ($method === 'ligdicash') {
            return redirect()->route('payments.ligdicash.initiate', ['order' => $order->publicRouteParameter()]);
        }

        $order->update(['payment_method' => $method]);

        $provider = $gateway->getProvider($method);
        $result = $provider->initiatePayment($order);

        if ($method === 'orange_money') {
            $order->update(['payment_reference' => $result['transaction_id']]);
            return view('orders.payment_om', compact('order', 'result'));
        }

        return redirect()->away($result['redirect_url']);
    }

    /**
     * Process payment (OM OTP or Visa)
     */
    public function processPayment(Request $request, Order $order, \App\Services\Payment\PaymentGateway $gateway)
    {
        $provider = $gateway->getProvider($order->payment_method);
        
        if ($provider->processPayment($order, $request->all())) {
            // Envoyer l'email de confirmation
            try {
                \Illuminate\Support\Facades\Mail::to($order->user_email)->send(new \App\Mail\OrderConfirmed($order));
            } catch (\Exception $e) {
                // On log l'erreur mais on ne bloque pas le client
                \Illuminate\Support\Facades\Log::error("Erreur d'envoi d'email : " . $e->getMessage());
            }

            return redirect()->route('orders.confirmation', ['order' => $order->publicRouteParameter()])->with('success', 'Paiement réussi !');
        }

        return back()->with('error', 'Le paiement a échoué. Veuillez réessayer.');
    }

    /**
     * Visa specific view
     */
    public function showVisaForm(Order $order)
    {
        return view('orders.payment_visa', compact('order'));
    }

    /**
     * Secure download of product files
     */
    public function download(Order $order, Product $product)
    {
        // 1. Vérification de sécurité et non-répudiation
        if ($order->payment_status !== Order::STATUS_PAID) {
            abort(403, 'Le paiement de cette commande n\'a pas encore été validé.');
        }

        // 2. Vérification que le produit appartient bien à la commande
        $hasProduct = $order->items()->where('product_id', $product->id)->exists();
        if (!$hasProduct) {
            abort(404, 'Ce produit ne fait pas partie de votre commande.');
        }

        // 3. Vérification que le produit est téléchargeable
        if (!$product->is_downloadable || !$product->file_path) {
            abort(404, 'Ce produit n\'est pas un contenu téléchargeable.');
        }

        // 4. Livraison sécurisée
        if (!\Illuminate\Support\Facades\Storage::exists($product->file_path)) {
            abort(404, 'Le fichier est introuvable sur nos serveurs.');
        }

        return \Illuminate\Support\Facades\Storage::download($product->file_path, $product->slug . '.' . pathinfo($product->file_path, PATHINFO_EXTENSION));
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
