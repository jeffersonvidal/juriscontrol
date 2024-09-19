<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Support\Facades\DB;
use Exception;
use HelpersAdm;
use Illuminate\Http\Request;


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

    /**Envia registros para popular tabela na index */
    public function getall(): JsonResponse
    {
        $labels = Label::all();
        return response()->json($labels);
    }

    public function show(Label $label)
    {
        $theLabel = Label::where('id',$label)->first();
        //return response()->json($theLabel);
        return response()->json($theLabel);
    }

    /**Salva registro no banco de dados */
    public function store(LabelRequest $request)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //Model da tabela - campos a serem salvos
            $label = Label::create([
                'name' => $request->name,
                'hexa_color_bg' => $request->hexa_color_bg,
                'hexa_color_font' => $request->hexa_color_font,
                'company_id' => $request->company_id,
            ]);

            //comita depois de tudo ter sido salvo
            DB::commit();

            //Redireciona para outra página após cadastrar com sucesso
            return response()->json( ['success' => 'Registro cadastrado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**Atualiza registro no banco de dados */
    public function update(LabelRequest $request, Label $label)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $label->update($request->validated());

            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json($label);
            return response()->json(['success' => 'Registro alterado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
            //return back()->withInput()->with('error', 'Erro ao cadastrar registro!<br>Tente novamente! Du doido<br>'.$e->getMessage());
        }

    }

    /**Exclui registro do banco de dados */
    public function destroy(Label $label)
    {
        //$theLabel = Label::where('id',$label)->delete();
        $label->delete();
        return response()->json(null, 204);
    }


}
