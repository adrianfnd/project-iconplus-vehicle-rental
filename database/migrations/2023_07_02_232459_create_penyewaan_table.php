<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyewaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kendaraan');
            $table->foreign('id_kendaraan')->references('id')->on('kendaraan')->onDelete('cascade');
            $table->uuid('id_jabatan')->nullable();
            $table->foreign('id_jabatan')->references('id')->on('jabatan')->onDelete('cascade');
            $table->uuid('id_vendor')->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendor')->onDelete('cascade');
            $table->uuid('id_driver')->nullable();
            $table->foreign('id_driver')->references('id')->on('driver')->onDelete('cascade');
            $table->boolean('include_driver')->default(false);
            $table->string('nama_penyewa');
            $table->string('kontak_penyewa');
            $table->string('sewa_untuk')->nullable();
            $table->integer('jumlah_hari_sewa');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('is_outside_bandung')->default(false);
            $table->integer('kilometer_awal')->nullable();
            $table->integer('kilometer_akhir')->nullable();
            $table->decimal('nilai_sewa', 10, 2)->nullable();
            $table->decimal('biaya_bbm', 10, 2)->nullable();
            $table->decimal('biaya_tol', 10, 2)->nullable();
            $table->decimal('biaya_parkir', 10, 2)->nullable();
            $table->decimal('biaya_driver', 10, 2)->nullable();
            $table->decimal('total_biaya', 10, 2)->nullable();
            $table->string('nomor_io')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('status');
            $table->string('reject_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyewaan');
    }
};