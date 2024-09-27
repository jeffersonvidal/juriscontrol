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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->integer('wallet_id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('customer_id');
            $table->integer('invoice_category_id');
            $table->integer('invoice_of');
            $table->string('type');
            $table->double('amount');
            $table->date('due_at');
            $table->string('repeat_when');
            $table->string('preiod');
            $table->integer('enrollments');
            $table->integer('enrollment_of');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
