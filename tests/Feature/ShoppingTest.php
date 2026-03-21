<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShoppingTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_published_products()
    {
        Product::factory()->count(3)->create(['published' => true]);
        Product::factory()->create(['published' => false]);

        $response = $this->get('/produits');

        $response->assertStatus(200);
    }

    public function test_cannot_view_unpublished_product_detail()
    {
        $product = Product::factory()->create(['published' => false]);

        $response = $this->get("/produits/{$product->slug}");

        $response->assertStatus(404);
    }

    public function test_can_view_published_product_detail()
    {
        $product = Product::factory()->create(['published' => true]);

        $response = $this->get("/produits/{$product->slug}");

        $response->assertStatus(200);
    }
}
