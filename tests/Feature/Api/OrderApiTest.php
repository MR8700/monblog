<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Admin;

class OrderApiTest extends TestCase
{
    public function test_can_create_order_with_products()
    {
        $product1 = Product::factory()->create(['price' => 100]);
        $product2 = Product::factory()->create(['price' => 50]);

        $response = $this->postJson('/api/v1/orders', [
            'user_name' => 'John Doe',
            'user_email' => 'john@example.com',
            'user_phone' => '+22600000000',
            'products' => [
                ['id' => $product1->id, 'quantity' => 2],
                ['id' => $product2->id, 'quantity' => 1],
            ],
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'user_email' => 'john@example.com',
            'total_price' => 250,
        ]);
    }

    public function test_admin_can_list_orders()
    {
        $admin = Admin::factory()->create();
        Order::factory()->count(5)->create();

        if (class_exists('Laravel\\Sanctum\\Sanctum')) {
            call_user_func(['Laravel\\Sanctum\\Sanctum', 'actingAs'], $admin);
        } else {
            $this->actingAs($admin, 'admin');
        }

        $response = $this->getJson('/api/v1/orders');

        $response->assertStatus(200);
        $this->assertCount(5, $response->json('data'));
    }

    public function test_admin_can_update_order_status()
    {
        $admin = Admin::factory()->create();
        $order = Order::factory()->create();

        if (class_exists('Laravel\\Sanctum\\Sanctum')) {
            call_user_func(['Laravel\\Sanctum\\Sanctum', 'actingAs'], $admin);
        } else {
            $this->actingAs($admin, 'admin');
        }

        $response = $this->putJson("/api/v1/orders/{$order->id}", [
            'status' => 'confirmed',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_order_validation_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/v1/orders', [
            'user_name' => '',
            'user_email' => 'invalid-email',
            'user_phone' => '123',
        ]);

        $response->assertStatus(422);
    }
}
