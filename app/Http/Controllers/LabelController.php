<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Label;
use DB;
use Exception;
use HelpersAdm;
use Illuminate\Http\Request;
use Log;
use Validator;

class LabelController extends Controller
{
    private $helperAdm;

    public function __construct(HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    public function index(){
        $labels = Label::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        //Carrega a view
        return view('labels.index', ['labels' => $labels]);
    }

    /**Salvar registro no banco de dados */
    public function store(Request $request){
        /**'name','hexa_color_bg', 'hexa_color_font','company_id' */
        //Validar o formulário
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'hexa_color_bg' => 'required',
            'hexa_color_font' => 'required',
            'company_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{

            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            try {
                $labelData = new Label;
                $labelData->name = $request->name;
                $labelData->hexa_color_bg = $request->hexa_color_bg;
                $labelData->hexa_color_font = $request->hexa_color_font;
                $labelData->company_id = $request->company_id;
                $labelData->save();

                //dd($userData);
                //comita depois de tudo ter sido salvo
                DB::commit();

                //Salvar log
                Log::info('Usuário, cadastrou o registro.', ['userLogged_id' => auth()->user()->id, 'registro_id'=> $labelData->id, 'registro_name' => $labelData->name]);

                //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
                return response()->json(['success' => true, 'msg' => 'Etiqueta cadastrada com sucesso!']);
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

    /**Atualiza registro no banco de dados */
    public function update(Request $request){
        //Validar o formulário
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'hexa_color_bg' => 'required',
            'hexa_color_font' => 'required',
            'company_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{

            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            try {
                //dd($request);
                $editLabel = Label::where('id', $request->id)->update([
                    'name' => $request->name,
                    'hexa_color_bg' => $request->hexa_color_bg,
                    'hexa_color_font' => $request->hexa_color_font,
                ]);
                //comita depois de tudo ter sido salvo
                DB::commit();

                //Salvar log
                Log::info('Usuário, alterou o registro.', ['userLogged_id' => auth()->user()->id, 'registro_id'=> $request->id, 'registro_name' => $request->name]);

                //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
                return response()->json(['success' => true, 'msg' => 'Etiqueta alterada com sucesso!']);
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
    public function destroy(Label $label){
        try {
            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            //$deleteUser = User::where('id', $user)->delete();
            $deleteLabel = Label::where('id', $label->id)
            ->where('company_id', auth()->user()->company_id)->delete();

            //comita depois de tudo ter sido salvo
            DB::commit();

            //Salvar log
            Log::info('Usuário, excluiu o registro.', ['userLogged_id' => auth()->user()->id, 'registro_id'=> $label->id, 'registro_name' => $label->name]);

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
