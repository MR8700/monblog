<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

App\Models\Admin::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => Illuminate\Support\Facades\Hash::make('Admin123!'),
]);

echo "admin_created\n";
