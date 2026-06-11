<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Richard Kouamé',
                'password' => Hash::make('password1234'),
                'role' => 'super_admin',
                'specialty' => 'Expert Full-Stack & Architecture Cloud',
                'bio' => 'Passionné par le développement web depuis plus de 10 ans, j\'accompagne les entreprises dans leur transformation digitale avec des solutions robustes et évolutives.',
                'skills' => ['Laravel', 'React', 'AWS', 'Docker', 'SEO'],
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'design@gmail.com'],
            [
                'name' => 'Sophie Traoré',
                'password' => Hash::make('password1234'),
                'role' => 'admin',
                'specialty' => 'UI/UX Designer & Direction Artistique',
                'bio' => 'Créative et rigoureuse, Sophie donne vie à vos idées à travers des interfaces intuitives et esthétiques qui captivent vos utilisateurs.',
                'skills' => ['Figma', 'Adobe XD', 'Illustrator', 'Motion Design'],
            ]
        );
    }
}
