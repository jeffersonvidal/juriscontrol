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
            $table->integer('wallet_id'); //id da carteira onde será lançada a fatura
            $table->integer('user_id'); //id do usuário que cadastrou a fatura
            $table->integer('company_id'); //id da empresa/escritório logado
            $table->integer('customer_id')->nullable(); //id do cliente
            $table->integer('invoice_category_id'); //id da categoria da fatura
            $table->integer('invoice_of')->nullable();
            $table->string('type'); //receita (income) ou despesa (expense)
            $table->double('amount'); //valor total da fatura
            $table->date('due_at'); //data de vencimento
            $table->string('repeat_when'); //se é unica, fixa ou parcelada
            $table->string('preiod')->nullable(); //quando for fixa (mensal/anual)
            $table->integer('enrollments'); //quantidade de parcelas
            $table->integer('enrollment_of'); //número da parcela
            $table->string('status'); //pago, não pago, atrasado
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
