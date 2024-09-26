<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class ExternalOffice extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'external_offices';

    //Quais colunas para serem cadastradas
    protected $fillable = ['name','company_id', 'responsible','phone',
            'email','cnpj','pix','agency','current_account','bank'];

    public function task(){
        return $this->hasMany(Task::class);
    }
}


