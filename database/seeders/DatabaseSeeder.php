<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Post;
use App\Models\Product;
use App\Models\PortfolioItem;
use App\Models\Order;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        
        $admin = Admin::where('email', 'admin@gmail.com')->first();

        // Seed Posts
        if (Post::count() === 0) {
            Post::factory(10)->create(['admin_id' => $admin->id]);
        }

        // Seed Products
        if (Product::count() === 0) {
            Product::factory(10)->create(['admin_id' => $admin->id]);
        }

        // Seed Portfolio
        if (PortfolioItem::count() === 0) {
            PortfolioItem::factory(5)->create(['admin_id' => $admin->id]);
        }

        // Seed Orders
        if (Order::count() === 0) {
            Order::factory(5)->create(['admin_id' => $admin->id])->each(function ($order) {
                OrderItem::factory(3)->create([
                    'order_id' => $order->id,
                    'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
                ]);
            });
        }
    }
}
