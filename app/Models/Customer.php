<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use Illuminate\Database\Eloquent\SoftDeletes;
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class Customer extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;

    //Table name
    protected $table = 'customers';

    //Quais colunas para serem cadastradas
    protected $fillable = ['company_id', 'name','email','phone','rg',
    'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday'];

    /**Relacionamento com tabela endereço de cliente - customer_addresses */
    public function address(){
        /**
         * return $this->hasOne(model da tabela relacionada - endereço do cliente::class, 'chave estrangeira da tabela de endereço', 'chave primária da tabela local');
         */
        return $this->hasMany(CustomerAddress::class);
    }

    //retorna o enderço do cliente relacionado
    public function customerAddress($customer){
        return CustomerAddress::where('customer_id', $customer)->get();
    }

}
