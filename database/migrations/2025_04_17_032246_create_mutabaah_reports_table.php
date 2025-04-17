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
        Schema::create('mutabaah_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentee_id')->constrained('mentee_id')->on('mentee_profiles')->onDelete('cascade');
            $table->enum('solat_berjamaah', ['IYA', 'TIDAK']);
            $table->enum('baca_quraan', ['IYA', 'TIDAK']);
            $table->enum('solat_duha', ['IYA', 'TIDAK']);
            $table->enum('puasa_sunnah', ['IYA', 'TIDAK']);
            $table->enum('sodaqoh_subuh', ['IYA', 'TIDAK']);
            $table->enum('relasibaru', ['IYA', 'TIDAK']);
            $table->enum('menabung', ['IYA', 'TIDAK']);
            $table->enum('penjualan', ['IYA', 'TIDAK']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutabaah_reports');
    }
};
