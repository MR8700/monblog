<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCustomerController extends Controller
{
    /**
     * Liste des clients unique basés sur l'email des commandes.
     */
    public function index(Request $request)
    {
        $query = Order::select('user_email', 'user_name', 'user_phone', 
            DB::raw('count(*) as orders_count'),
            DB::raw('sum(total_price) as total_spent'),
            DB::raw('max(created_at) as last_order_at')
        );

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'LIKE', "%{$search}%")
                  ->orWhere('user_email', 'LIKE', "%{$search}%")
                  ->orWhere('user_phone', 'LIKE', "%{$search}%");
            });
        }

        $customers = $query->groupBy('user_email', 'user_name', 'user_phone')
            ->orderByDesc('last_order_at')
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Détails d'un client et son historique d'achats.
     */
    public function show($email)
    {
        $customerOrders = Order::where('user_email', $email)
            ->with('items.product', 'items.post')
            ->latest()
            ->get();

        if ($customerOrders->isEmpty()) {
            abort(404, 'Client introuvable');
        }

        $customer = (object) [
            'email' => $email,
            'name' => $customerOrders->first()->user_name,
            'phone' => $customerOrders->first()->user_phone,
            'orders' => $customerOrders,
            'total_spent' => $customerOrders->sum('total_price'),
            'orders_count' => $customerOrders->count(),
        ];

        return view('admin.customers.show', compact('customer'));
    }
}
