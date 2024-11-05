<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

class AdminController extends Controller
{
    public function __construct() { 
        // Compartilhar dados com todas as views 
        $this->middleware(function ($request, $next) { 
            $lembretes = Lembrete::all(); 
            $notificacoes = Notificacao::all(); 
            View::share(compact('lembretes', 'notificacoes')); 
            return $next($request); 
        }); 
    } 
    public function index() { 
        return view('dashboard.index'); 
    }
}
