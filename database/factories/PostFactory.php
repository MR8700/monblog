<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'admin_id' => Admin::factory(),
            'title' => $this->faker->realText(50),
            'slug' => $this->faker->unique()->slug(),
            'excerpt' => $this->faker->realText(200),
            'body' => $this->faker->realText(2000),
            'published' => true,
            'published_at' => now(),
            'views_count' => $this->faker->numberBetween(0, 1000),
        ];
    }

    public function unpublished(): self
    {
        return $this->state(['published' => false]);
    }
}
