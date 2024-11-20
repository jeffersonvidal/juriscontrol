<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory; 
    protected $fillable = [ 
        'reminder_date', 
        'responsible_id', 
        'description', 
        'author_id', 
        'status', 
    ];
}
