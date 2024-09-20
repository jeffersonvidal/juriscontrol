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
        Schema::create('court_cases', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('title');
            $table->integer('status');
            $table->double('amount_charged');
            $table->string('form_of_payment');
            $table->integer('label_id');
            $table->longText('description');
            $table->double('amount_paid');
            $table->integer('author_user_id');
            $table->integer('company_id');
            $table->integer('responsible_employee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_cases');
    }
};
