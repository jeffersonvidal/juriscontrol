<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;

class ForgotPasswordController extends Controller
{
    /**Carrega formulário para solicitar recuperação de senha */
    public function showForgotPassword(){
        /**Carrega a view */
        return view('login.forgotPassword');
    }

    /**Envia a solicitação de recuperação de senha por email */
    public function submitForgotPassword(Request $request){
        //dd($request);
        /**Validar formulário */
        $request->validate([
            'email' => 'required|email',
        ],[
            'email.required' => 'O campo email é obrigatório!',
            'email.email' => 'Digite um email válido!',
        ]);

        try {
            /**Verifica se o usuário existe no sistema */
            $user = User::where('email', $request->email)->first();

            /**Verifica se encontrou o usuário */
            if(!$user){
                /**Salva log */
                Log::warning('Tentativa de recuperar senha com email não cadastrado.', ['email' => $request->email]);

                /**Redireciona o usuário, enviar mensagem de erro */
                return back()->withInput()->with('error', 'Email não encontrado!');
            }

            //Redireciona para outra página após cadastrar com sucesso
            return response()->json( ['success' => 'Registro cadastrado com sucesso!']);
        } catch (Exception $e) {

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
        }
    }


}
