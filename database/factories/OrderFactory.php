<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'admin_id' => null,
            'user_name' => $this->faker->name(),
            'user_email' => $this->faker->email(),
            'user_phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'processing', 'completed', 'cancelled']),
            'total_price' => $this->faker->randomFloat(2, 50, 5000),
        ];
    }
}
