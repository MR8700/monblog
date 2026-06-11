<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'status')) {
                $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->after('published');
            }
            if (!Schema::hasColumn('posts', 'visibility')) {
                $table->enum('visibility', ['public', 'private', 'hidden'])->default('public')->after('status');
            }
            if (!Schema::hasColumn('posts', 'scheduled_at')) {
                $table->timestamp('scheduled_at')->nullable()->after('published_at');
            }
            if (!Schema::hasColumn('posts', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('scheduled_at');
            }
            if (!Schema::hasColumn('posts', 'reading_time')) {
                $table->unsignedInteger('reading_time')->default(0)->comment('minutes')->after('archived_at');
            }
            if (!Schema::hasColumn('posts', 'featured')) {
                $table->boolean('featured')->default(false)->after('reading_time');
            }
            if (!Schema::hasColumn('posts', 'meta_keywords')) {
                $table->string('meta_keywords')->nullable()->after('featured');
            }
            if (!Schema::hasColumn('posts', 'meta_description')) {
                $table->string('meta_description')->nullable()->after('meta_keywords');
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $columns = ['status', 'visibility', 'scheduled_at', 'archived_at', 'reading_time', 'featured', 'meta_keywords', 'meta_description'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
