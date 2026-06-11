<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        $posts = [
            [
                'title' => 'Les tendances du développement web en 2024',
                'excerpt' => 'Découvrez les technologies et frameworks qui dominent le marché cette année.',
                'body' => 'Le développement web évolue rapidement. De l\'essor de l\'IA à la popularité croissante de frameworks comme Next.js et Laravel, voici ce qu\'il faut savoir...',
            ],
            [
                'title' => 'Comment optimiser votre SEO pour Google',
                'excerpt' => 'Guide complet pour améliorer la visibilité de votre blog sur les moteurs de recherche.',
                'body' => 'Le SEO n\'est pas seulement une question de mots-clés. C\'est une stratégie globale incluant la vitesse du site, la qualité du contenu et l\'expérience utilisateur...',
            ],
            [
                'title' => 'Pourquoi choisir Laravel pour vos projets PHP ?',
                'excerpt' => 'Analyse des avantages du framework Laravel pour les développeurs modernes.',
                'body' => 'Laravel offre une syntaxe élégante, des outils robustes comme Eloquent et Blade, et un écosystème florissant qui facilite le développement d\'applications complexes...',
            ],
            [
                'title' => 'L\'importance du design responsive',
                'excerpt' => 'Assurez-vous que votre site s\'affiche parfaitement sur tous les appareils.',
                'body' => 'Avec plus de 50% du trafic web provenant de mobiles, avoir un design qui s\'adapte automatiquement à la taille de l\'écran est devenu une nécessité absolue...',
            ],
            [
                'title' => 'Sécuriser votre application web : Les bonnes pratiques',
                'excerpt' => 'Protégez vos données et celles de vos utilisateurs contre les cyberattaques.',
                'body' => 'La sécurité doit être une priorité dès la conception. Utilisez HTTPS, protégez-vous contre les injections SQL et assurez une gestion rigoureuse des mots de passe...',
            ],
        ];

        foreach ($posts as $post) {
            Post::create(array_merge($post, [
                'admin_id' => $admin->id,
                'slug' => Str::slug($post['title']),
                'published' => true,
                'published_at' => now(),
                'views_count' => rand(100, 5000),
            ]));
        }
    }
}
