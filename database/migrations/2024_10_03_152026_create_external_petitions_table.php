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
        Schema::create('external_petitions', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id'); //id da carteira em que será lançado o valor
            $table->integer('user_id'); //id do usuário que está cadastrando no sistema
            $table->integer('company_id'); //empresa responsável pelo lançamento
            $table->integer('external_office_id'); //id do escritório externo
            $table->integer('responsible'); //id do usuário do sistema responsável por processar o registro
            $table->date('delivery_date'); //data de entrega da petição
            $table->integer('type'); //rt, contestação, manifestação, ro, rr, ed, análise de sentença, análise processual, análise de caso
            $table->string('customer_name'); //nome do cliente da petição
            $table->string('process_number')->nullable(); //nº do processo
            $table->string('court')->nullable(); //tribunal
            $table->longText('notes')->nullable(); //observações
            $table->double('amount'); //valor cobrado
            $table->string('status')->default('started'); //iniciada, em andamento, concluído
            $table->string('payment_status')->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    //     customer_name, wallet_id, user_id, company_id, status(iniciada(started), em andamento(in_progress), concluído(completed)),
// origem (escritórios), data recebimento, responsável, data entrega,
// tipo (RT, Contestação, Manifestação, RO, RR, ED, Análise de Sentença, Análise Processual, Análise de Caso),
// cliente, processo, tribunal, observações, valor, payment_status (pago (paid), pendente(pending), atrasado(late))

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_petitions');
    }
};
