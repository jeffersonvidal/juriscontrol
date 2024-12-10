<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserProfile;
use DB;
use Exception;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $helperAdm;
    private $userProfile;

    public function __construct(\HelpersAdm $helpersAdm, UserProfile $userProfile){
        $this->helperAdm = $helpersAdm;
        $this->userProfile = $userProfile;
    }

    /**Listar registros da tabela do banco de dados */
    public function index(){
        $allUsers = User::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        /**carrega view para mostrar todos os registros */
        return view('users.index', 
            compact('allUsers')
        );
    }
    
    /**Visualizar registro específico (individual) */
    public function show(User $user, Request $request){
        $user = User::where('company_id', auth()->user()->company_id)
        ->where('id', $user)->first();

        return response()->json($user);
    }

    /**Envia registros para popular tabela na index */
    public function getall()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**Salvar registro no banco de dados */
    public function store(UserRequest $request){
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $userData = new User;
            $userData->name = $request->name;
            $userData->email = $request->email;
            $userData->password = $request->password;
            $userData->company_id = $request->company_id;
            $userData->user_profile_id = $request->user_profile_id;
            $userData->phone = $this->helperAdm->limpaCampo($request->phone);
            $userData->cpf = $this->helperAdm->limpaCampo($request->cpf);
            $userData->birthday = $request->birthday;
            $userData->save();

            // Pegando o ID do usuário recém-cadastrado
            $userID = $userData->id;

            // Atualizando a URL de referência
            $referral_url = config('app.url') . "/create-customer-self/" . auth()->user()->company_id . "-" . $userID;
            $userData->referral_url = $referral_url;
            $userData->save();

            //dd($userData);
            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            return response()->json(['success' => 'Usuário cadastrado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Retorna mensagem de erro ao cadastrar registro no BD
            return response()->json(['error' => $e->getMessage()]);
        }        
        
    }

    /**Atualiza registro no banco de dados */
    public function update(UserRequest $request, User $user){
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $user = User::where('id', $user->id)
                ->where('company_id', auth()->user()->company_id)
                ->first();

            if ($user) {

                // Verificar se o campo referral_url está vazio 
                
                if (empty($user->referral_url)) { 
                    $referral_url = config('app.url') . "/create-customer-self/" . auth()->user()->company_id . "-" . $user->id; 
                    $user->referral_url = $referral_url; 
                }
                
                $editUser = $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'company_id' => $request->company_id,
                    'user_profile_id' => $request->user_profile_id,
                    'phone' => $request->phone,
                    'cpf' => $request->cpf,
                    'birthday' => $request->birthday,
                    'referral_url' => $referral_url,
                ]);
            }
            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            return response()->json(['success' => 'Usuário alterado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Retorna mensagem de erro ao cadastrar registro no BD
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**Excluir registro do banco de dados */
    public function destroy(User $user){
        try {
            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            //$deleteUser = User::where('id', $user)->delete();
            $deleteUser = User::where('id', $user->id)
            ->where('company_id', auth()->user()->company_id)->delete();

            //comita depois de tudo ter sido salvo
            DB::commit();

            return response()->json(['success' => 'Registro excluído com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
        
    }
}
