<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'admin_id')) {
                $table->foreignId('admin_id')->nullable()->after('id')->constrained('admins')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'admin_id')) {
                $table->dropForeignIdFor('products');
                $table->dropColumn('admin_id');
            }
        });
    }
};
