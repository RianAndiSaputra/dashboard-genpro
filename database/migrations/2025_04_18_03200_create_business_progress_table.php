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
        Schema::create('business_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('omzet_id');
            $table->unsignedBigInteger('hpp_id');
            $table->unsignedBigInteger('biayaops_id');
            $table->unsignedBigInteger('gross_profit_id');
            $table->unsignedBigInteger('net_profit_id');
            $table->unsignedBigInteger('gross_profit_margin_id');
            $table->unsignedBigInteger('nett_profit_marign_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
            
            // Define foreign keys with explicit names
            $table->foreign('omzet_id')
                  ->references('id')
                  ->on('omzets')
                  ->onDelete('cascade');
                  
            $table->foreign('hpp_id')
                  ->references('id')
                  ->on('hpps')
                  ->onDelete('cascade');
                  
            $table->foreign('biayaops_id')
                  ->references('id')
                  ->on('biayaops')
                  ->onDelete('cascade');
                  
            $table->foreign('gross_profit_id')
                  ->references('id')
                  ->on('gross_profits')
                  ->onDelete('cascade');
                  
            $table->foreign('net_profit_id')
                  ->references('id')
                  ->on('net_profits')
                  ->onDelete('cascade');
                  
            $table->foreign('gross_profit_margin_id')
                  ->references('id')
                  ->on('gross_profit_margins')
                  ->onDelete('cascade');
                  
            $table->foreign('nett_profit_marign_id')
                  ->references('id')
                  ->on('nett_profit_margins')
                  ->onDelete('cascade');
                  
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_progress');
        Schema::dropIfExists('nett_profit_margin');
        Schema::dropIfExists('gross_profit_margin');
        Schema::dropIfExists('net_profit');
        Schema::dropIfExists('gross_profit');
        Schema::dropIfExists('biayaops');
        Schema::dropIfExists('hpp');
        Schema::dropIfExists('omzet');
    }
};
