<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Task extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    /** Table name */
    protected $table = 'tasks';

    /** Table fields */
    protected $fillable = [
        'description',
        'priority',
        'label_id',
        'end_date',
        'law_suit_case_id',
        'owner_user_id',
        'company_id',
        'employees_id',
    ];

    /**Retorna usuário pelo id */
    public function getUser($user){
        return User::where('company_id', auth()->user()->company_id)
        ->where('id', $user)
        ->orderBy('id', 'DESC')->first();
    }

    //retorna empregados envolvidos com a tarefa
    public function usersTask($users){
        $indice_users = explode(',', $users);
        foreach ($indice_users as $indice) {
            $employee = User::where('id', $indice)
                ->where('company_id', auth()->user()->company_id)
                ->first();
            if ($employee) {
                return $employee->name . ', ';
            }
        }
    }
}
