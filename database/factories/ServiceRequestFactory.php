<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceRequestFactory extends Factory
{
    protected $model = ServiceRequest::class;

    public function definition(): array
    {
        $services = ['Graphisme', 'Développement Web', 'E-concours', 'E-timbre', 'Montage Vidéo', 'Référencement SEO'];
        $statuses = ['pending', 'processing', 'quoted', 'paid', 'delivered', 'cancelled'];

        return [
            'client_name' => $this->faker->name(),
            'client_email' => $this->faker->unique()->safeEmail(),
            'client_phone' => $this->faker->phoneNumber(),
            'service_type' => $this->faker->randomElement($services),
            'description' => $this->faker->paragraph(3),
            'custom_fields' => [
                ['label' => 'Délai souhaité', 'value' => $this->faker->randomElement(['1 semaine', '2 semaines', '1 mois'])],
                ['label' => 'Budget estimé', 'value' => $this->faker->numberBetween(100, 5000) . '€']
            ],
            'price' => $this->faker->randomFloat(2, 50, 2000),
            'status' => $this->faker->randomElement($statuses),
            'admin_notes' => $this->faker->optional()->sentence(),
        ];
    }
}
