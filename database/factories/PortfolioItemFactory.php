<?php

namespace Database\Factories;

use App\Models\PortfolioItem;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioItemFactory extends Factory
{
    protected $model = PortfolioItem::class;

    public function definition(): array
    {
        return [
            'admin_id' => Admin::factory(),
            'title' => $this->faker->sentence(3),
            'role' => $this->faker->jobTitle(),
            'stack' => implode(', ', $this->faker->words(3)),
            'summary' => $this->faker->paragraph(),
            'link' => $this->faker->url(),
            'started_at' => $this->faker->date(),
            'is_current' => $this->faker->boolean(),
            'featured' => $this->faker->boolean(),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
