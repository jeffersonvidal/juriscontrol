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
            $table->foreignId('invoice_id')->constrained('invoices'); //id da fatura
            $table->integer('customer_id')->nullable(); //id do cliente
            $table->integer('enrollment_of'); //nº da parcela
            $table->string('method'); //card, money, pix, ted, bank slip(boleto)
            $table->double('amount_owed'); //valor devido (valor da parcela)
            $table->double('amount_paid'); //valor pago
            $table->date('pay_day'); //dia do pagamento
            $table->double('amount_remaining'); //valor restante em caso de abatimento do valor
            $table->string('status'); //não pago (unpaid), pago (paid)
            $table->timestamps();
        });
    }

//     id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
// amount_owed, amount_paid, pay_day, amount_remaining, status

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
