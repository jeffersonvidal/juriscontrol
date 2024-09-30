<?php

namespace App\Models;

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
    protected $fillable = ['description','wallet_id', 'user_id','company_id', 'customer_id',
    'invoice_category_id', 'invoice_of', 'type', 'amount', 'due_at', 'repeat_when', 'preiod', 
    'enrollments', 'enrollment_of', 'status'];

    public function getStatus($status){
        if($status == 'unpaid'){
            return 'Não Pago';
        }
        if($status == 'paid'){
            return 'Pago';
        }
    }

    public function getType($type){
        if($type == 'income'){
            return 'Receita/Entrada';
        }
        if($type == 'expense'){
            return 'Despesa/Saída';
        }
    }
}
