<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**Responsável pela auditoria do sistema */
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Priority extends Model implements Auditable
{
    use HasFactory, AuditingAuditable;

    /** Table name */
    protected $table = 'priorities';

    /** Table fields */
    protected $fillable = [
        'name',
        'color',
    ];

    public function task(){
        return $this->hasMany(Task::class);
    }
}
