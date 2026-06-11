<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Admin;

class PostApiTest extends TestCase
{
    public function test_can_list_published_posts()
    {
        Post::factory()->count(3)->create(['published' => true]);
        Post::factory()->create(['published' => false]);
        
        $response = $this->getJson('/api/v1/posts');
        
        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));
    }

    public function test_can_view_published_post()
    {
        $post = Post::factory()->create(['published' => true]);
        
        $response = $this->getJson("/api/v1/posts/{$post->id}");
        
        $response->assertStatus(200);
        $response->assertJsonPath('id', $post->id);
    }

    public function test_cannot_view_unpublished_post()
    {
        $post = Post::factory()->create(['published' => false]);
        
        $response = $this->getJson("/api/v1/posts/{$post->id}");
        
        $response->assertStatus(404);
    }

    public function test_admin_can_create_post()
    {
        $admin = Admin::factory()->create();
        if (class_exists('Laravel\\Sanctum\\Sanctum')) {
            call_user_func(['Laravel\\Sanctum\\Sanctum', 'actingAs'], $admin);
        } else {
            $this->actingAs($admin, 'admin');
        }

        $response = $this->postJson('/api/v1/posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post content',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    public function test_cannot_create_post_without_auth()
    {
        $response = $this->postJson('/api/v1/posts', [
            'title' => 'Test Post',
            'body' => 'Test',
        ]);

        $response->assertStatus(401);
    }
}
