<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Wallet extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'wallets';

    //Quais colunas para serem cadastradas
    protected $fillable = ['name', 'agency', 'current_account', 'balance', 
    'company_id', 'type', 'holder', 'main'];
}

/**
 * balance = saldo
 * type = personal/business
 * holder = titular
 * main = principal
 */
