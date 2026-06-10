<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Service Requests
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->string('service_type'); // linked to service_types name or free text
            $table->text('description');
            $table->json('custom_fields')->nullable(); // Store type/value pairs
            $table->decimal('price', 10, 2)->nullable();
            $table->string('status')->default('pending'); // pending, processing, quoted, paid, delivered, cancelled
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // Attachments for Service Requests
        Schema::create('service_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type');
            $table->timestamps();
        });

        // Deliveries System (Secure Space)
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path'); // The real file
            $table->string('preview_path')->nullable(); // High quality preview image
            $table->decimal('price', 10, 2);
            $table->string('status')->default('unpaid'); // unpaid, paid
            $table->string('secure_token')->unique();
            $table->boolean('is_public')->default(false);
            $table->json('reactions')->nullable(); // Store counts or users
            $table->timestamps();
        });

        // Delivery Comments
        Schema::create('delivery_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained()->onDelete('cascade');
            $table->string('author_name');
            $table->text('content');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_comments');
        Schema::dropIfExists('deliveries');
        Schema::dropIfExists('service_request_attachments');
        Schema::dropIfExists('service_requests');
    }
};
