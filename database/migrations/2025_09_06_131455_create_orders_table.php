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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
               // TEAM
            $table->unsignedBigInteger('host_id')->nullable();     // dari karyawans
            $table->unsignedBigInteger('co_host_id')->nullable();  // dari karyawans
            $table->unsignedBigInteger('cs_id')->nullable();       // dari admins

            // EKSPEDISI
            $table->string('ekspedisi')->nullable();
            $table->string('berat')->nullable(); // Kg
            $table->integer('ongkir')->nullable();

            // TRANSAKSI
            $table->bigInteger('total_transfer')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('bank_transfer')->nullable();
            $table->enum('status', ['LUNAS', 'DOWN PAYMENT', 'PRE ORDER', 'SHOPEE'])->nullable();

            // CUSTOMER
            $table->string('nama_penerima')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('kodepos')->nullable();
            $table->text('alamat')->nullable();

            $table->integer('komisi_host')->nullable();
            $table->integer('komisi_co_host')->nullable();
            $table->integer('komisi_cs')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
