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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('fantasy_name');
            $table->string('corporate_reason');
            $table->string('email')->unique();
            $table->string('cnpj')->unique();
            $table->string('phone');
            $table->integer('user_id');
            //$table->foreignId('user_id')->constrained('users')->onDelete('cascade'); //relacionamento com tabela customers
            $table->integer('company_address_id');
            //$table->foreignId('company_address_id')->constrained('company-addresses')->onDelete('cascade'); //relacionamento com tabela customers
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
