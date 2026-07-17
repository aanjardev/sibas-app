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
        Schema::create('transaksi_belanja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_belanja', 15, 2);
            $table->decimal('bayar_saldo', 15, 2)->default(0);
            $table->decimal('bayar_tunai', 15, 2)->default(0);
            $table->enum('status', ['pending', 'selesai', 'batal'])->default('selesai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_belanja');
    }
};
