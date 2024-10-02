<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'payments';

    //Quais colunas para serem cadastradas
    protected $fillable = ['wallet_id', 'user_id', 'company_id', 'invoice_id', 'customer_id', 'method', 
    'enrollment_of', 'amount_owed', 'amount_paid', 'pay_day', 'amount_remaining', 'status'];

    public function getMethodPayment($paymentId){
        $method = Payment::where('id', $paymentId)
        ->where('company_id', auth()->user()->company_id)->first();
        if($method->method == 'pix'){
            return 'PIX';
        }

        if($method->method == 'card'){
            return 'Cartão';
        }

        if($method->method == 'money'){
            return 'Dinheiro';
        }

        if($method->method == 'ted'){
            return 'TED';
        }

        if($method->method == 'bank_slip'){
            return 'Boleto';
        }
    }
    public function getInvoice($invoiceId){
        return Invoice::where('id', $invoiceId)
        ->where('company_id', auth()->user()->company_id)->first();
    }

    public function getInvoiceType($invoiceId){
        $invoice = Invoice::where('id', $invoiceId)
        ->where('company_id', auth()->user()->company_id)->first();
        if($invoice->type == 'income'){
            return 'Receita';
        }
        if($invoice->type == 'expense'){
            return 'Despesa';
        }
    }
    public function getInvoiceCategory($invoiceId){
        $categoryId = $this->getInvoice($invoiceId)->invoice_category_id;
        return InvoiceCategory::where('id', $categoryId)
        ->where('company_id', auth()->user()->company_id)->first();
    }
}


//     id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
// amount_owed, amount_paid, pay_day, amount_remaining, status