<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Hearing extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'hearings';

    //Quais colunas para serem cadastradas
    protected $fillable = ['object','company_id','user_id','responsible','status',
    'date_happen','time_happen','external_office_id','client','local','type',
    'process_num','modality','informed_client','informed_witnesses','link',
    'notes','amount','payment_status',];

    /**Mostra o tipo do objeto cadastrado */
    public function getObject($hearingId){
        $hearing = Hearing::where('id', $hearingId)
        ->where('company_id', auth()->user()->company_id)->first();
        if($hearing->object == 'hearing'){
            return 'Audiência';
        }
        if($hearing->object == 'expertise'){
            return 'Perícia';
        }
        if($hearing->object == 'meeting'){
            return 'Reunião';
        }
        if($hearing->object == 'petition'){
            return 'Petição';
        }
        if($hearing->object == 'diligence'){
            return 'Diligência';
        }
    }

    /**Retorna nome do responsável por processar  */
    public function getResponsible($userId){
        return User::where('id', $userId)
        ->where('company_id', auth()->user()->company_id)->first();
    }

    /**Retorna nome do responsável por processar  */
    public function getStatus($status){
        if($status == 'open'){
            return 'Aberto';
        }
        if($status == 'canceled'){
            return 'Cancelado';
        }
        if($status == 'completed'){
            return 'Concluído';
        }
    }

    /**Retorna escritórios externos */
    public function getExternalOffices($externalOffice){
        $externalOffices = ExternalOffice::where('id', $externalOffice)
        ->where('company_id', auth()->user()->company_id)->first();
        if($externalOffices){
            return $externalOffices->name;
        }
    }

    /**Retorna o tipo (inicial, conciliação, diligência, instrução) */
    public function getType($type){
        $hearing = Hearing::where('type', $type)
        ->where('company_id', auth()->user()->company_id)->first();
        if($hearing->type == 'initial'){
            return 'Inicial';
        }
        if($hearing->type == 'conciliation'){
            return 'Conciliação';
        }
        if($hearing->type == 'expert_due_dilivence'){
            return 'Diligência Pericial';
        }
        if($hearing->type == 'instruction'){
            return 'Instrução';
        }
        if($hearing->type == 'una'){
            return 'Una';
        }
        if($hearing->type == 'visit'){
            return 'Visita';
        }
        if($hearing->type == 'instruction_closure'){
            return 'Encerramento de Instrução';
        }
    }

    /**Retorna o status de pagamento */
    public function getPaymentStatus($hearingId){
        $hearing = Hearing::where('id', $hearingId)
        ->where('company_id', auth()->user()->company_id)->first();
        if($hearing->payment_status == 'unpaid'){
            return 'Não Pago';
        }

        if($hearing->payment_status == 'paid'){
            return 'Pago';
        }
    }
}


// $table->string('object'); //hearing(audiência), expertise(perícia), meeting(reunião), petition(petição), diligence(diligência)
// $table->integer('company_id');
// $table->integer('user_id');
// $table->integer('responsible');
// $table->string('status')->default('open'); //open(aberto), canceled(cancelado), completed(concluído)
// $table->date('date_happen'); //data para acontecer
// $table->string('external_office_id'); //id do escritório parceiro
// $table->string('client'); //nome do cliente
// $table->string('local'); //local onde acontecerá
// $table->time('time_happen'); //horário que acontecerá
// $table->string('type'); //initial(inicial), conciliation(conciliação), expert_due_dilivence(diligencia pericial), instruction(instrução), una, visit(visita), instruction_closure(encerramento de instrução)
// $table->string('process_num')->nullable(); //nº do processo
// $table->string('modality'); //modalidade (online, in_person(presencial))
// $table->string('informed_client')->default('n'); //cliente informado (s/n)
// $table->string('informed_witnesses')->default('n'); //testemunhas informadas (s/n)
// $table->string('link')->nullable(); //link das audiências em caso de online
// $table->longText('notes')->nullable(); //observações
// $table->double('amount')->default(0); //valor cobrado
// $table->string('payment_status')->default('unpaid'); //paid, unpaid