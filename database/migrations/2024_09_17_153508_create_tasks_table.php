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
            $table->string('title');
            $table->string('status');
            $table->string('source'); //origem (escritórios parceiros ou não)
            $table->date('delivery_date'); //data de entrega da tarefa
            $table->date('end_date'); //data fatal para executar a tarefa
            $table->string('responsible_id'); //responsável por executar a tarefa
            $table->string('author_id')->constrained('users'); //quem cadastra a tarefa no sistema
            $table->string('client')->nullable(); //nome do cliente
            $table->string('process_number')->nullable();
            $table->string('court')->nullable(); //tribunal
            $table->string('priority')->default('1');
            $table->integer('label_id')->nullable();
            $table->longText('description');
            $table->integer('company_id');
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
