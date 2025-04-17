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
            // $table->unsignedBigInteger('mentor_id');
            // $table->unsignedBigInteger('secretary_id');
            $table->timestamps();
            
            // Define foreign keys separately
            // $table->foreign('mentor_id')
            //       ->references('user_id')
            //       ->on('users')
            //       ->onDelete('cascade');
                  
            // $table->foreign('secretary_id')
            //       ->references('user_id')
            //       ->on('users')
            //       ->onDelete('cascade');
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
