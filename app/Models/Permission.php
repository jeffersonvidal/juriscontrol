<?php

namespace App\Models;

/**Responsável pela auditoria do sistema */
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Permission extends Model implements Auditable
{
    use HasFactory, AuditingAuditable, HasRoles;

    //Table name
    protected $table = 'permissions';

    //Quais colunas para serem cadastradas
    protected $fillable = ['name','title', 'guard_name', 'company_id'];
}
