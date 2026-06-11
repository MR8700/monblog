<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Admin;

class OrderTest extends TestCase
{
    public function test_order_has_many_items()
    {
        $order = Order::factory()->create();
        $items = OrderItem::factory()->count(3)->create(['order_id' => $order->id]);
        
        $this->assertCount(3, $order->items);
    }

    public function test_order_belongs_to_admin()
    {
        $admin = Admin::factory()->create();
        $order = Order::factory()->create(['admin_id' => $admin->id]);
        
        $this->assertTrue($order->admin->is($admin));
    }

    public function test_order_item_has_correct_relation()
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();
        $item = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);
        
        $this->assertTrue($item->product->is($product));
        $this->assertTrue($item->order->is($order));
    }

    public function test_order_total_price_casting()
    {
        $order = Order::factory()->create(['total_price' => 99.99]);
        
        $this->assertIsString($order->total_price);
        $this->assertStringContainsString('99.99', (string)$order->total_price);
    }
}
