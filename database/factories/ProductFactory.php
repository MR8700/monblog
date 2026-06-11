<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'admin_id' => Admin::factory(),
            'title' => $this->faker->realText(30),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->realText(500),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'published' => true,
        ];
    }
}
