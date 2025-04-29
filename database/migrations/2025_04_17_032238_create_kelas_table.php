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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->enum('kategori_kelas', ['Online', 'Tatap Muka', 'Hybrid']);
            $table->string('lokasi_zoom')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['Aktif', 'Dijadwalkan', 'Selesai']);
            $table->text('deskripsi_kelas')->nullable();
            $table->unsignedInteger('kuota_peserta');
            $table->string('pdf_path')->nullable();
            $table->unsignedBigInteger('mentor_id');
            $table->unsignedBigInteger('secretary_id');
            $table->unsignedBigInteger('mentee_id')->nullable();
            $table->timestamps();
        
            // Foreign keys yang benar
            $table->foreign('mentor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('secretary_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mentee_id')->references('id')->on('users')->onDelete('cascade');
            $table->json('user_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};