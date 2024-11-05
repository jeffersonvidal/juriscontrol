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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id(); 
            $table->longText('message'); 
            $table->string('type');  //warning, info, success, danger
            $table->dateTime('alert_time'); 
            $table->boolean('active')->default(true); 
            $table->integer('company_id');
            $table->integer('target_user_id');
            $table->integer('author_id');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
