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
        Schema::create('business_financials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hpp__id');
            $table->unsignedBigInteger('biyaya_ops__id');
            $table->unsignedBigInteger('gross_profit__id');
            $table->unsignedBigInteger('nett_profit__id');
            $table->unsignedBigInteger('gross_profit_margin__id');
            $table->unsignedBigInteger('nett_profit_margin__id');
            $table->unsignedBigInteger('capaian_target_neet_profit__id');
            $table->unsignedBigInteger('company_id');
            $table->integer('realisasi');
            $table->timestamps();
            
            // Define foreign keys with explicit names
            $table->foreign('hpp__id')
                  ->references('id')
                  ->on('hpp_')
                  ->onDelete('cascade');
                  
            $table->foreign('biyaya_ops__id')
                  ->references('id')
                  ->on('biyaya_ops_')
                  ->onDelete('cascade');
                  
            $table->foreign('gross_profit__id')
                  ->references('id')
                  ->on('gross_profit_')
                  ->onDelete('cascade');
                  
            $table->foreign('nett_profit__id')
                  ->references('id')
                  ->on('nett_profit_')
                  ->onDelete('cascade');
                  
            $table->foreign('gross_profit_margin__id')
                  ->references('id')
                  ->on('gross_profit_margin_')
                  ->onDelete('cascade');
                  
            $table->foreign('nett_profit_margin__id')
                  ->references('id')
                  ->on('nett_profit_margin_')
                  ->onDelete('cascade');
                  
            $table->foreign('capaian_target_neet_profit__id')
                  ->references('id')
                  ->on('capaian_target_nett_profit_')
                  ->onDelete('cascade');
                  
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_financial');
        Schema::dropIfExists('capaian_target_nett_profit_');
        Schema::dropIfExists('nett_profit_margin_');
        Schema::dropIfExists('gross_profit_margin_');  
        Schema::dropIfExists('nett_profit_');
        Schema::dropIfExists('gross_profit_');
        Schema::dropIfExists('biayaops_');
        Schema::dropIfExists('hpp_');
    }
};
