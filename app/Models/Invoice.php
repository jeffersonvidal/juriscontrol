<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class Invoice extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;

    //Table name
    protected $table = 'invoices';

    //Quais colunas para serem cadastradas
    protected $fillable = ['external_petition_id', 'external_audience_id', 'description','wallet_id', 'user_id','company_id', 'customer_id',
    'invoice_category_id', 'invoice_of', 'type', 'amount', 'due_at', 'repeat_when', 'period', 
    'enrollments', 'enrollment_of', 'status'];


    public function getStatus($status, $id){
        $today = Carbon::now();
        $checkInvoice = Invoice::find($id);
        $dataInvoice = Carbon::parse($checkInvoice->due_at);

        if($dataInvoice->lt($today) AND $status == 'paid'){
            return 'Pago';
        }

        if($dataInvoice->lt($today) AND $status == 'unpaid'){
            return 'Atrasado';
        }

        if($dataInvoice->lt($today) AND $status == 'partial'){
            return 'Parc. - Atras.';
        }else{
            return 'Não Pago';
        }

    }
//amount_remaining
    public function getAmountRemaining($invoiceId){
        $amountRemaining = Payment::where('invoice_id', $invoiceId)
        ->where('company_id', auth()->user()->company_id)->first();
        return ($amountRemaining == null) ? 0 : $amountRemaining->amount_remaining;
    }

    public function getType($type){
        if($type == 'income'){
            return 'Receita';
        }
        if($type == 'expense'){
            return 'Despesa';
        }
    }

    public function getCategory($category){
        $theCategory = InvoiceCategory::where('id', $category)
            ->where('company_id', auth()->user()->company_id)->first();
        return $theCategory->name;
    }

    /**Pega o número do mês da data informada */
    public function getNumberMonth($data){
        $carbonDate = Carbon::createFromFormat('Y-m-d', $data);
        return $carbonDate->format('m');
    }

    /**Pega o número do mês atual */
    public function getCurrentNumberMonth(){
        Carbon::setLocale('pt_BR');
        $data = Carbon::now();
        return $data->format('m');
    }

    /**Pega o número do ano atual */
    public function getCurrentNumberYear(){
        Carbon::setLocale('pt_BR');
        $data = Carbon::now();
        return $data->format('Y');
    }

    /**Pega quantidade de parcelas de uma fatura */
    public function getEnrollments($invoice, $type){
        return Invoice::where('description', $invoice)
            ->where('type', $type)->count();
    }

    /**Pega dados do escritório parceiro */
    public function getExternalOffice($invoiceId){
        $invoice = Invoice::where('id', $invoiceId)->first();
        $externalPetition = '';
        if($invoice->external_petition_id != 0 OR $invoice->external_petition_id != null){
            $externalPetition = $invoice->external_petition_id;
        }

        if($externalPetition){
            $petition = ExternalPetition::where('id', $externalPetition)
            ->where('company_id', auth()->user()->company_id)->first();

            $externalOffice = ExternalOffice::where('id', $petition->external_office_id)
            ->where('company_id', auth()->user()->company_id)->first();

            return ($externalOffice ? $externalOffice->name : 'Próprio');
        }

        return 'Próprio';
    }

      
}
