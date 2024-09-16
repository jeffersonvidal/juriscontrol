<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;


class UserController extends Controller
{
    private $helperAdm;

    public function __construct(\HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
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
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'company_id' => 'required',
            'user_profile_id' => 'required',
            'phone' => 'required',
            'cpf' => 'required',
            'birthday' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{

            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            try {
                $userData = new User;
                $userData->name = $request->name;
                $userData->email = $request->email;
                $userData->password = $request->password;
                $userData->company_id = $request->company_id;
                $userData->user_profile_id = $request->user_profile_id;
                $userData->phone = $userData->limpaPhone($request->phone);
                $userData->cpf = $userData->limpaCPF($request->cpf);
                $userData->teste = $this->helperAdm->convertStringToDouble('7.321.256,32');
                $userData->birthday = $request->birthday;
                //$userData->save();

                dd($userData);
                //comita depois de tudo ter sido salvo
                DB::commit();

                //Salvar log
                Log::info('Usuário, cadastrou o registro.', ['userLogged_id' => auth()->user()->id, 'userUpdated_id'=> $user->id, 'user_name' => $user->name]);

                //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
                return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            } catch (Exception $e) {
                //Desfazer a transação caso não consiga cadastrar com sucesso no BD
                DB::rollBack();

                //Salvar log
                Log::notice('Erro ao cadastrar registro.', ['userLogged_id'=> auth()->user()->id, 'error' => $e->getMessage()]);

                //Retorna mensagem de erro ao cadastrar registro no BD
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
        }
        
        
    }

    /**Carrega formulário para editar registro */
    public function edit(){
        return view('users.edit');
    }

    /**Atualiza registro no banco de dados */
    public function update(Request $request, User $user){
        //Validar o formulário
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'company_id' => 'required',
            'user_profile_id' => 'required',
            'phone' => 'required',
            'cpf' => 'required',
            'birthday' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{

            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            try {
                $editUser = User::where('id', $user->id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'company_id' => $request->company_id,
                    'user_profile_id' => $request->user_profile_id,
                    'phone' => $request->phone,
                    'cpf' => $request->cpf,
                    'birthday' => $request->birthday,
                ]);
                //comita depois de tudo ter sido salvo
                DB::commit();

                //Salvar log
                Log::info('Usuário, alterou o registro.', ['userLogged_id' => auth()->user()->id, 'userUpdated_id'=> $user->id, 'user_name' => $user->name]);

                //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
                return response()->json(['success' => true, 'msg' => 'Usuário alterado com sucesso!']);
            } catch (Exception $e) {
                //Desfazer a transação caso não consiga cadastrar com sucesso no BD
                DB::rollBack();

                //Salvar log
                Log::notice('Erro ao alterar registro.', ['userLogged_id'=> auth()->user()->id, 'error' => $e->getMessage()]);

                //Retorna mensagem de erro ao cadastrar registro no BD
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
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

            //Salvar log
            Log::info('Usuário, excluiu o registro.', ['userLogged_id' => auth()->user()->id, 'userUpdated_id'=> $user->id, 'user_name' => $user->name]);

            return response()->json(['success' => true, 'msg' => 'Registro excluído com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Salvar log
            Log::notice('Erro ao excluir registro.', ['userLogged_id'=> auth()->user()->id, 'error' => $e->getMessage()]);

            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
        
    }
}
