<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**Listar registros da tabela do banco de dados */
    public function index(){
        $allUsers = User::all();
        /**carrega view para mostrar todos os registros */
        return view('users.index', 
            compact('allUsers')
        );
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
    public function store(UserRequest $request){
        //Validar o formulário
        $request->validated();

            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            /**
             *  'name', 'email', 'password', 'company_id', 'user_profile_id', 'phone', 'cpf', 'birthday'
             */

            try {
                $userData = new User;
                $userData->name = $request->name;
                $userData->email = $request->email;
                $userData->password = $request->password;
                $userData->company_id = $request->company_id;
                $userData->user_profile_id = $request->user_profile_id;
                $userData->phone = $request->phone;
                $userData->cpf = $request->cpf;
                $userData->birthday = $request->birthday;
                $userData->save();
                //comita depois de tudo ter sido salvo
                DB::commit();
                //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
                return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            } catch (Exception $e) {
                //Desfazer a transação caso não consiga cadastrar com sucesso no BD
                DB::rollBack();
                //Retorna mensagem de erro ao cadastrar registro no BD
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        
        
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
