<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('post_tag_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('post_tag_id')->constrained('post_tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['post_id', 'post_tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag_pivot');
        Schema::dropIfExists('post_tags');
    }
};
