<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//Fazer auditoria dos registros
use \OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, SoftDeletes, AuditingAuditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'company_id', 'user_profile_id', 'phone', 'cpf', 'birthday'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**Remove caracteres de campos (CPF, CEP, Data, etc) */
    public function clearField($param){
        if(empty($param)){
            return '';
        }

        return str_replace(['.','-','(',')','/',' '], '', $param);
    }

    /**Limpa CPF */
    public function limpaCPF($value){
        return $this->attributes['cpf'] = $this->clearField($value);
    }

    /**Limpa CEP */
    public function limpaCEP($value){
        return $this->attributes['zipcode'] = $this->clearField($value);
    }

    /**Limpa Phone */
    public function limpaPhone($value){
        return $this->attributes['phone'] = $this->clearField($value);
    }

    /**Converte string to Double - para valores monetários */
    public function convertStringToDouble($param){
        if(empty($param)){
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }


}
