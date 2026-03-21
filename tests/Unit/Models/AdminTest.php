<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\Post;
use App\Models\Product;
use App\Models\Order;
use App\Models\ChatMessage;
use App\Models\PortfolioItem;

class AdminTest extends TestCase
{
    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
    }

    public function test_admin_has_posts()
    {
        $post = Post::factory()->create(['admin_id' => $this->admin->id]);
        
        $this->assertTrue($this->admin->posts->contains($post));
    }

    public function test_admin_has_products()
    {
        $product = Product::factory()->create(['admin_id' => $this->admin->id]);
        
        $this->assertTrue($this->admin->products->contains($product));
    }

    public function test_admin_has_orders()
    {
        $order = Order::factory()->create(['admin_id' => $this->admin->id]);
        
        $this->assertTrue($this->admin->orders->contains($order));
    }

    public function test_admin_has_chat_messages()
    {
        $message = ChatMessage::factory()->create(['admin_id' => $this->admin->id]);
        
        $this->assertTrue($this->admin->chatMessages->contains($message));
    }
}
