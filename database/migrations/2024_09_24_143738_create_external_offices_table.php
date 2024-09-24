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
        Schema::create('external_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('company_id');
            $table->string('responsible');
            $table->string('phone');
            $table->string('email');
            $table->string('cnpj');
            $table->string('pix')->nullable();
            $table->string('agency')->nullable();
            $table->string('current_account')->nullable();
            $table->string('bank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_offices');
    }
};
