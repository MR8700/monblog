<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolio_items', 'admin_id')) {
                $table->foreignId('admin_id')->nullable()->after('id')->constrained('admins')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            if (Schema::hasColumn('portfolio_items', 'admin_id')) {
                $table->dropForeignIdFor('portfolio_items');
                $table->dropColumn('admin_id');
            }
        });
    }
};
