<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use Illuminate\Database\Eloquent\SoftDeletes;
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class CustomerAddress extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;

    //Table name
    protected $table = 'customer_addresses';

    //Quais colunas para serem cadastradas
    protected $fillable = ['zipcode','street', 'num','complement', 'neighborhood', 
    'city', 'state', 'company_id', 'customer_id', 'main'];

    //Relacionamento muitos para um, com Client Table
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
