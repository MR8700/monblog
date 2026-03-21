<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_medias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name');
            $table->string('filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('size'); // en bytes
            $table->enum('type', ['image', 'video', 'document', 'apk', 'audio', 'file'])->default('file');
            $table->text('description')->nullable();
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index('post_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_medias');
    }
};
