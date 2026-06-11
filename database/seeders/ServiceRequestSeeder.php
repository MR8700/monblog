<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use Illuminate\Database\Seeder;

class ServiceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $requests = [
            [
                'client_name' => 'Jean Dupont',
                'client_email' => 'jean.dupont@example.com',
                'client_phone' => '0123456789',
                'service_type' => 'Développement Web',
                'description' => 'Création d\'un site e-commerce pour ma boutique de vêtements.',
                'price' => 1200.00,
                'status' => 'paid',
            ],
            [
                'client_name' => 'Marie Curie',
                'client_email' => 'marie.curie@labo.fr',
                'client_phone' => '0987654321',
                'service_type' => 'Graphisme',
                'description' => 'Refonte de l\'identité visuelle et création d\'un nouveau logo.',
                'price' => 450.00,
                'status' => 'paid',
            ],
            [
                'client_name' => 'Luc Besson',
                'client_email' => 'luc.b@cinema.com',
                'client_phone' => '0611223344',
                'service_type' => 'Montage Vidéo',
                'description' => 'Montage d\'une vidéo promotionnelle de 2 minutes pour un court-métrage.',
                'price' => 800.00,
                'status' => 'pending',
            ],
            [
                'client_name' => 'Alice Martin',
                'client_email' => 'alice.m@seo.com',
                'client_phone' => '0700112233',
                'service_type' => 'Référencement SEO',
                'description' => 'Optimisation du référencement naturel pour mon blog culinaire.',
                'price' => 300.00,
                'status' => 'processing',
            ],
        ];

        foreach ($requests as $request) {
            ServiceRequest::create(array_merge($request, [
                'custom_fields' => [
                    ['label' => 'Délai souhaité', 'value' => '2 semaines'],
                    ['label' => 'Urgent', 'value' => 'Non']
                ],
            ]));
        }
    }
}
