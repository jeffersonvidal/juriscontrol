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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->integer('responsible_id');
            $table->unsignedBigInteger('company_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('status')->default(0)->nullable();
            $table->integer('is_all_day')->default(0)->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('event_id')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
