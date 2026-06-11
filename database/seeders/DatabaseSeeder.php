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
        $this->call([
            AdminSeeder::class,
            PostSeeder::class,
            ProductSeeder::class,
            ServiceRequestSeeder::class,
        ]);
        
        $admin = Admin::where('email', 'admin@gmail.com')->first();

        // Seed Portfolio
        if (PortfolioItem::count() === 0) {
            PortfolioItem::factory(5)->create(['admin_id' => $admin->id]);
        }

        // Seed Orders
        if (Order::count() === 0) {
            Order::factory(5)->create(['admin_id' => $admin->id])->each(function ($order) {
                OrderItem::factory(3)->create([
                    'order_id' => $order->id,
                    'product_id' => \App\Models\Product::inRandomOrder()->first()->id ?? \App\Models\Product::factory(),
                ]);
            });
        }
    }
}
