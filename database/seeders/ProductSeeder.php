<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        $products = [
            [
                'title' => 'Thème WordPress Premium - Portfolio',
                'description' => 'Un thème moderne et élégant pour présenter vos travaux de graphisme ou de photographie.',
                'price' => 49.99,
                'type' => Product::TYPE_APP,
            ],
            [
                'title' => 'E-book : Devenir Développeur Full-Stack',
                'description' => 'Un guide complet de 300 pages pour apprendre les bases du web jusqu\'au déploiement.',
                'price' => 24.50,
                'type' => Product::TYPE_WORK,
            ],
            [
                'title' => 'Template de Dashboard Admin Laravel',
                'description' => 'Une interface d\'administration prête à l\'emploi avec gestion des utilisateurs et stats.',
                'price' => 89.00,
                'type' => Product::TYPE_APP,
            ],
            [
                'title' => 'Audit SEO Complet',
                'description' => 'Nous analysons votre site et vous fournissons un rapport détaillé pour améliorer votre trafic.',
                'price' => 150.00,
                'type' => Product::TYPE_SERVICE,
            ],
            [
                'title' => 'Pack de Logos Vectoriels',
                'description' => 'Plus de 500 logos modifiables pour vos futurs projets de design.',
                'price' => 15.00,
                'type' => Product::TYPE_TASK,
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'admin_id' => $admin->id,
                'slug' => Str::slug($product['title']),
                'published' => true,
            ]));
        }
    }
}
