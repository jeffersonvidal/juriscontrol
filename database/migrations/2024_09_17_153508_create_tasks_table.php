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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->string('priority');
            $table->integer('label_id');
            $table->date('end_date');
            $table->integer('law_suit_case_id');
            $table->integer('owner_user_id');
            $table->integer('company_id');
            $table->string('employees_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
