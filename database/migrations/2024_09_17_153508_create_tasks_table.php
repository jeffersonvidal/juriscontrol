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
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');//
            $table->id();
            $table->string('title');
            $table->string('status');
            $table->integer('source'); //origem (escritórios parceiros ou não)
            $table->date('delivery_date'); //data de entrega da tarefa
            $table->date('end_date'); //data fatal para executar a tarefa
            $table->integer('responsible_id'); //responsável por executar a tarefa
            $table->integer('author_id'); //quem cadastra a tarefa no sistema
            $table->string('client')->nullable(); //nome do cliente
            $table->string('process_number')->nullable();
            $table->string('court')->nullable(); //tribunal
            $table->integer('priority')->default(1);
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
