<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Post;
use App\Models\Admin;
use App\Models\PostComment;
use App\Models\PostReaction;

class PostTest extends TestCase
{
    public function test_post_belongs_to_admin()
    {
        $admin = Admin::factory()->create();
        $post = Post::factory()->create(['admin_id' => $admin->id]);
        
        $this->assertTrue($post->admin->is($admin));
    }

    public function test_post_has_comments()
    {
        $post = Post::factory()->create();
        $comments = PostComment::factory()->count(3)->create(['post_id' => $post->id]);
        
        $this->assertCount(3, $post->comments);
    }

    public function test_post_has_reactions()
    {
        $post = Post::factory()->create();
        $reactions = PostReaction::factory()->count(5)->create(['post_id' => $post->id]);
        
        $this->assertCount(5, $post->reactions);
    }

    public function test_post_slug_auto_generated()
    {
        $post = Post::factory()->create(['title' => 'Mon Article Test', 'slug' => null]);
        
        $this->assertNotNull($post->slug);
        $this->assertStringContainsString('mon-article-test', $post->slug);
    }

    public function test_post_auto_casting()
    {
        $post = Post::factory()->create(['published' => true]);
        
        $this->assertTrue(is_bool($post->published));
    }
}
