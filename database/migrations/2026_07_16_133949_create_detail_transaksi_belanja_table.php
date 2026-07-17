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
        Schema::create('detail_transaksi_belanja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_belanja_id')->constrained('transaksi_belanja')->onDelete('cascade');
            $table->foreignId('kategori_produk_id')->constrained('kategori_produk')->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_belanja');
    }
};
