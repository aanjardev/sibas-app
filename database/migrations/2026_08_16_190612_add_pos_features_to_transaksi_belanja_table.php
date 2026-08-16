<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksi_belanja', function (Blueprint $table) {
            $table->decimal('diskon', 15, 2)->default(0)->after('total_belanja');
            $table->decimal('uang_diterima', 15, 2)->default(0)->after('bayar_tunai');
            $table->decimal('kembalian', 15, 2)->default(0)->after('uang_diterima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_belanja', function (Blueprint $table) {
            $table->dropColumn(['diskon', 'uang_diterima', 'kembalian']);
        });
    }
};
