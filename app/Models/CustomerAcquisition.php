<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**Responsável pela auditoria do sistema */
use Illuminate\Database\Eloquent\SoftDeletes;
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class CustomerAcquisition extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;

    //Table name
    protected $table = 'customer_acquisitions';

    //Quais colunas para serem cadastradas
    protected $fillable = ['user_id', 'customer_id','company_id'];
}
