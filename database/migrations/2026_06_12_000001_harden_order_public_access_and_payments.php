<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'public_token')) {
                $table->string('public_token', 64)->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('orders', 'ligdicash_token_hash')) {
                $table->string('ligdicash_token_hash', 64)->nullable()->after('payment_reference');
            }

            if (!Schema::hasColumn('orders', 'payment_processed_at')) {
                $table->timestamp('payment_processed_at')->nullable()->after('payment_status');
            }
        });

        DB::table('orders')
            ->whereNull('public_token')
            ->orderBy('id')
            ->chunkById(100, function ($orders): void {
                foreach ($orders as $order) {
                    DB::table('orders')
                        ->where('id', $order->id)
                        ->update(['public_token' => Str::random(48)]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'public_token')) {
                $table->dropUnique(['public_token']);
                $table->dropColumn('public_token');
            }

            if (Schema::hasColumn('orders', 'ligdicash_token_hash')) {
                $table->dropColumn('ligdicash_token_hash');
            }

            if (Schema::hasColumn('orders', 'payment_processed_at')) {
                $table->dropColumn('payment_processed_at');
            }
        });
    }
};
