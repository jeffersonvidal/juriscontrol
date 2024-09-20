<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class Customer extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'customers';

    //Quais colunas para serem cadastradas
    protected $fillable = ['company_id', 'name','email','phone','rg',
    'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday'];

}
