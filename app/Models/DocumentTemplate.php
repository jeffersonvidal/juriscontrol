<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    //Table name
    protected $table = 'document_templates';

    //Quais colunas para serem cadastradas
    protected $fillable = ['title', 'content', 'company_id', 'author_id','type', 'area'];
}
