<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalOfficeRequest;
use App\Models\ExternalOffice;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Http\Request;
use HelpersAdm;

class ExternalOfficeController extends Controller
{
    private $helperAdm;

    public function __construct(HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        return view('external_offices.index', ['externalOffices' => $externalOffices]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExternalOfficeRequest $request)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();
        
        try {
            //Model da tabela - campos a serem salvos
            $externalOfficeData = new ExternalOffice;
            $externalOfficeData->name = $request->name;
            $externalOfficeData->responsible = $request->responsible;
            $externalOfficeData->phone = $this->helperAdm->limpaCampo($request->phone);
            $externalOfficeData->email = $request->email;
            $externalOfficeData->cnpj = $this->helperAdm->limpaCampo($request->cnpj);
            $externalOfficeData->pix = $request->pix;
            $externalOfficeData->agency = $request->agency;
            $externalOfficeData->current_account = $request->current_account;
            $externalOfficeData->bank = $request->bank;
            $externalOfficeData->company_id = $request->company_id;
            $externalOfficeData->save();

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

    /**
     * Display the specified resource.
     */
    public function show(ExternalOffice $externalOffice)
    {
        $theExternalOffice = ExternalOffice::where('id', $externalOffice)->first();

        return response()->json($theExternalOffice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExternalOfficeRequest $request, ExternalOffice $externalOffice)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //$label->update($request->validated());
            $externalOffice->name = $request->name;
            $externalOffice->responsible = $request->responsible;
            $externalOffice->phone = $this->helperAdm->limpaCampo($request->phone);
            $externalOffice->email = $request->email;
            $externalOffice->cnpj = $this->helperAdm->limpaCampo($request->cnpj);
            $externalOffice->pix = $request->pix;
            $externalOffice->agency = $request->agency;
            $externalOffice->current_account = $request->current_account;
            $externalOffice->bank = $request->bank;
            $externalOffice->company_id = $request->company_id;
            $externalOffice->update();

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalOffice $externalOffice)
    {
        //$theLabel = Label::where('id',$label)->delete();
        $externalOffice->delete();
        return response()->json(null, 204);
    }
}
