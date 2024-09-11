<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**Listar registros da tabela do banco de dados */
    public function index(){
        return view('users.index');
    }
    
    /**Visualizar registro específico (individual) */
    public function show(){
        return view('users.show');
    }

    /**Carrega formulário para cadastrar novo registro */
    public function create(){
        return view('users.create');
    }

    /**Salvar registro no banco de dados */
    public function store(){
        dd('cadastrar no banco de dados');
    }

    /**Carrega formulário para editar registro */
    public function edit(){
        return view('users.edit');
    }

    /**Atualiza registro no banco de dados */
    public function update(){
        dd('cadastrar no banco de dados');
    }

    /**Excluir registro do banco de dados */
    public function destroy(){
        return view('users.destroy');
    }
}
