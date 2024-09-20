<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
class CourtCase extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    //Table name
    protected $table = 'court_cases';

    //Quais colunas para serem cadastradas
    protected $fillable = [ 'customer_id', 'title', 'status', 'amount_charged', 
    'amount_paid', 'form_of_payment', 'label_id', 'description', 
    'author_user_id', 'company_id', 'responsible_employee_id'];
}
