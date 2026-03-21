<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Font Awesome class
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Add category_id to posts
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('admin_id')->constrained('post_categories')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'category_id')) {
                $table->dropForeignIdFor('posts');
                $table->dropColumn('category_id');
            }
        });

        Schema::dropIfExists('post_categories');
    }
};
