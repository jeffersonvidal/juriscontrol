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
}


//     id, wallet_id, user_id, company_id, invoice_id, customer_id, method, enrollment_of,
// amount_owed, amount_paid, pay_day, amount_remaining, status