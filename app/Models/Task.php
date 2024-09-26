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
        'title',
        'description',
        'delivery_date',
        'end_date',
        'responsible_id',
        'author_id',
        'client',
        'process_number',
        'court',
        'priority',
        'label_id',
        'status',
        'source',
        'company_id',
    ];


    //STATUS	ORIGEM	DATA	RESPONSÁVEL	DATA FATAL	TAREFA	CLIENTE	PROCESSO	TRIBUNAL	OBSERVAÇÕES

    //Relacionamento com outras tabelas
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function label(){
        return $this->belongsTo(Label::class);
    }
    public function externalOffice(){
        return $this->belongsTo(ExternalOffice::class);
    }
    public function priority(){
        return $this->belongsTo(Priority::class);
    }
    public function status(){
        return $this->belongsTo(SystemStatus::class);
    }

    /**Retorna usuário pelo id */
    public function getUser($user){
        return User::where('company_id', auth()->user()->company_id)
        ->where('id', $user)
        ->orderBy('id', 'DESC')->first();
    }

    

}
