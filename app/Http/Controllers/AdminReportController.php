<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    /**
     * Rapport des produits les plus vendus.
     */
    public function soldProducts()
    {
        // Produits physiques
        $productSales = OrderItem::whereNotNull('product_id')
            ->select('product_id', 
                DB::raw('sum(quantity) as total_sold'),
                DB::raw('sum(quantity * price) as total_revenue')
            )
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_sold')
            ->get();

        // Articles payants (Posts)
        $postSales = OrderItem::whereNotNull('post_id')
            ->select('post_id', 
                DB::raw('sum(quantity) as total_sold'),
                DB::raw('sum(quantity * price) as total_revenue')
            )
            ->groupBy('post_id')
            ->with('post')
            ->orderByDesc('total_sold')
            ->get();

        return view('admin.reports.products', compact('productSales', 'postSales'));
    }

    /**
     * Détails des acheteurs pour un produit spécifique.
     */
    public function productDetails(Product $product)
    {
        $sales = OrderItem::where('product_id', $product->id)
            ->with('order')
            ->latest()
            ->paginate(20);

        return view('admin.reports.item_details', [
            'item' => $product,
            'type' => 'product',
            'sales' => $sales
        ]);
    }

    /**
     * Détails des acheteurs pour un article spécifique.
     */
    public function postDetails(Post $post)
    {
        $sales = OrderItem::where('post_id', $post->id)
            ->with('order')
            ->latest()
            ->paginate(20);

        return view('admin.reports.item_details', [
            'item' => $post,
            'type' => 'post',
            'sales' => $sales
        ]);
    }
}
