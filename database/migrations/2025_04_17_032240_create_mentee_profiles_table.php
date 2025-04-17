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
        Schema::create('mentee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas_id')->on('kelas')->onDelete('set null');
            $table->foreignId('user_id')->constrained('user_id')->on('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('company_id')->on('companies')->onDelete('cascade');
            $table->string('address');
            $table->string('profile_picture')->nullable();
            $table->string('bidang_usaha');
            $table->string('badan_hukum');
            $table->string('tahun_berdiri');
            $table->integer('jumlah_karyawan');
            $table->integer('jumlah_omset');
            $table->string('jabatan');
            $table->enum('komitmen', ['iya', 'tidak']);
            $table->string('gambar_laporan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentee_profiles');
    }
};
