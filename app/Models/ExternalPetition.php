<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class ExternalPetition extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'external_petitions';

    //Quais colunas para serem cadastradas
    protected $fillable = ['wallet_id', 'user_id', 'company_id', 
    'external_office_id', 'responsible', 'delivery_date', 'type', 
    'customer_name', 'process_number', 'court', 'notes', 'amount', 
    'status', 'payment_status'];

    /**pega o escritório responsável pela petição */
    public function getExternalOffice($externalOfficeId){
        return ExternalOffice::where('id', $externalOfficeId)
        ->where('company_id', auth()->user()->company_id)->first();
    }

    /**Pega usuário responsável por processar petição */
    public function getResponsible($userId){
        return User::where('id', $userId)
        ->where('company_id', auth()->user()->company_id)->first();
    }
    
    /**Pega o tipo da petição */
    public function getTypePetition($typePetitionId){
        return TypePetition::where('id', $typePetitionId)
        ->where('company_id', auth()->user()->company_id)->first();
    }
    
    /**Pega o status da petição */
    public function getStatusPetition($petitionId){
        $statusPetition =  ExternalPetition::where('id', $petitionId)
        ->where('company_id', auth()->user()->company_id)->first();

        if($statusPetition->status == 'started'){
            return 'Iniciada';
        }
        if($statusPetition->status == 'in_progress'){
            return 'Em Andamento';
        }
        if($statusPetition->status == 'completed'){
            return 'Concluído';
        }
    }

    /**Pega status de pagamento */
    public function getPaymentStatus($paymentStatus){
        if($paymentStatus == 'paid'){
            return 'Pago';
        }
        if($paymentStatus == 'unpaid'){
            return 'Não Pago';
        }
    }
}

//     customer_name, wallet_id, user_id, company_id, status(iniciada(started), em andamento(in_progress), concluído(completed)),
// origem (escritórios), data recebimento, responsável, data entrega,
// tipo (RT, Contestação, Manifestação, RO, RR, ED, Análise de Sentença, Análise Processual, Análise de Caso),
// cliente, processo, tribunal, observações, valor, payment_status (pago (paid), pendente(pending), atrasado(late))