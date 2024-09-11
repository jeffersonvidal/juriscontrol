<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**Login */
    public function index(){
        return view('login.index');
    }

    /**Processa os dados informados no form de login */
    public function loginProcess(LoginRequest $request){
        /**Validar o formulário */
        $request->Validated();

        /**Validar email e senha com informações do banco de dados */
        $authenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        /**Verifica se o usuário foi autenticado */
        if(!$authenticated){
            /**Redireciona para tela de login novamente e envia mensagem de erro */
            return back()->withInput()->with('error', 'Email ou senha inválidos');
        }

        /**Se estiver tudo correto redireciona para dashboard */
        return redirect()->route('dashboard.index');
    }
}
