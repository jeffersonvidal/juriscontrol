<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use HasFactory;

    //Table name
    protected $table = 'events';

    //Quais colunas para serem cadastradas
    protected $fillable = ['company_id', 'author_id','responsible_id', 'start','end','status',
    'is_all_day','title', 'description', 'event_id', 'color'];
}
