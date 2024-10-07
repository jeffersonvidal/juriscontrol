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
        Schema::create('hearings', function (Blueprint $table) {
            $table->id();
            $table->string('object'); //hearing(audiência), expertise(perícia), meeting(reunião), petition(petição), diligence(diligência)
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('responsible');
            $table->string('status')->default('open'); //open(aberto), canceled(cancelado), completed(concluído)
            $table->date('date_happen'); //data para acontecer
            $table->string('external_office_id'); //id do escritório parceiro
            $table->string('client'); //nome do cliente
            $table->string('local'); //local onde acontecerá
            $table->time('time_happen'); //horário que acontecerá
            $table->string('type'); //initial(inicial), conciliation(conciliação), expert_due_dilivence(diligencia pericial), instruction(instrução), una, visit(visita), instruction_closure(encerramento de instrução)
            $table->string('process_num')->nullable(); //nº do processo
            $table->string('modality'); //modalidade (online, in_person(presencial))
            $table->string('informed_client')->default('n'); //cliente informado (s/n)
            $table->string('informed_witnesses')->default('n'); //testemunhas informadas (s/n)
            $table->string('link')->nullable(); //link das audiências em caso de online
            $table->longText('notes')->nullable(); //observações
            $table->double('amount')->default(0); //valor cobrado
            $table->string('payment_status')->default('unpaid'); //paid, unpaid
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hearings');
    }
};

// **Audiências, Perícias, Reuniões
// status(aberto, concluído, cancelado, a receber), objeto (audiência, perícia, reunião, petição, diligência),
// data acontecer, origem(escritórios), cliente, local, horario, tipo(inicial, conciliação, diligencia pericial, 
// instrução, una, visita, encerramento instrução), responsável, processo, modalidade(online, presencial), 
// cliente informado(sim, não), testemunhas informadas(sim, não), link, observações, valor, status(pago, pendente, atrasado)