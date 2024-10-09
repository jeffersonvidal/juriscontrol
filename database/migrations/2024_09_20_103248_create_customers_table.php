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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('name');
            $table->string('gdrive_folder_id')->nullable();
            $table->string('email')->unique(); //remover unique no SaaS
            $table->string('phone');
            $table->string('rg');
            $table->string('rg_expedidor');
            $table->string('cpf')->unique(); //remover unique no SaaS
            $table->string('marital_status');
            $table->string('nationality');
            $table->string('profession');
            $table->date('birthday');
            $table->string('met_us'); //no conheceu
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
