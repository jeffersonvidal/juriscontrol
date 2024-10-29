<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilePasswordRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\UserProfile;
use Auth;
use DB;
use Exception;
use HelpersAdm;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    private $helperAdm;
    private $userProfile;

    public function __construct(HelpersAdm $helpersAdm, UserProfile $userProfile){
        $this->helperAdm = $helpersAdm;
        $this->userProfile = $userProfile;
    }

    /**Listar registros da tabela do banco de dados */
    public function show(){
        $theUser = User::where('id', Auth::id())->first();

        /**carrega view para mostrar todos os registros */
        return view('profile.show', [
            'theUser' => $theUser,
        ]
        );
    }

    /**Atualiza registro no banco de dados */
    public function update(ProfileRequest $request, User $user){
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $editUser = User::where('id', Auth::id())->first();
            $editUser->name = $request->name;
            $editUser->email = $request->email;
            $editUser->company_id = $request->company_id;
            $editUser->user_profile_id = $request->user_profile_id;
            $editUser->phone = $request->phone;
            $editUser->cpf = $request->cpf;
            $editUser->birthday = $request->birthday;
            $editUser->update();
            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            return response()->json(['success' => 'Perfil alterado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Retorna mensagem de erro ao cadastrar registro no BD
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**Alterar senha */
    public function updatePassword(ProfilePasswordRequest $request, User $user){
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $editUser = User::where('id', Auth::id())->first();
            $editUser->password = $request->password;
            $editUser->update();
            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            return response()->json(['success' => 'Senha alterada com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Retorna mensagem de erro ao cadastrar registro no BD
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
