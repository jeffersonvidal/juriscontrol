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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id'); //id da carteira em que foi lançada a fatura
            $table->integer('user_id'); //id do usuário que fez o lançamento do pagamento
            $table->integer('company_id'); //id da empresa
            $table->integer('invoice_id'); //id da fatura
            $table->integer('customer_id')->nullable(); //id do cliente
            $table->integer('enrollment_of'); //nº da parcela
            $table->string('method'); //cartão, dinheiro, pix, ted
            $table->string('amount_owed'); //valor devido (valor da parcela)
            $table->string('amount_paid'); //valor pago
            $table->string('amount_remaining'); //valor restante em caso de abatimento do valor
            $table->string('status');
            $table->timestamps();
        });
    }

//     id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
// amount_owed, amount_paid, amount_remaining, status

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
