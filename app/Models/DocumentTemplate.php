<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class DocumentTemplate extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditingAuditable;
    //Table name
    protected $table = 'document_templates';

    //Quais colunas para serem cadastradas
    protected $fillable = ['title', 'content', 'company_id', 'author_id','type', 'area'];
}
