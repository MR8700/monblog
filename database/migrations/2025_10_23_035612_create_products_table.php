<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('image')->nullable(); // chemin fichier ou URL
            $table->decimal('price', 10, 2)->nullable();
            $table->string('whatsapp')->nullable(); // téléphone international sans +
            $table->string('facebook')->nullable(); // lien complet
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
