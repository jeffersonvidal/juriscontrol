<?php

namespace App\Http\Controllers;

use App\Http\Requests\HearingRequest;
use App\Models\ExternalOffice;
use App\Models\Hearing;
use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;

class HearingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hearings = Hearing::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        $users = User::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();


        //Carrega a view
        return view('hearings.index', [
            'hearings' => $hearings,
            'users' => $users,
            'externalOffices' => $externalOffices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HearingRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {

            $hearing = new Hearing;
            $hearing->informed_client = ($request->informed_client ? 's' : 'n');
            $hearing->informed_witnesses = ($request->informed_witnesses ? 's' : 'n');
            $hearing->object = $request->object;
            $hearing->responsible = $request->responsible;
            $hearing->status = ($request->status ?: 'unpaid');
            $hearing->date_happen = $request->date_happen;
            $hearing->time_happen = $request->time_happen;
            $hearing->external_office_id = $request->external_office_id;
            $hearing->client = $request->client;
            $hearing->local = $request->local;
            $hearing->type = $request->type;
            $hearing->process_num = $request->process_num;
            $hearing->modality = $request->modality;
            $hearing->link = $request->link;
            $hearing->payment_status = $request->payment_status;
            $hearing->notes = $request->notes;
            $hearing->amount = str_replace([".", ","], ["", "."], $request->amount);
            $hearing->company_id = $request->company_id;
            $hearing->user_id = $request->user_id;
            $hearing->save();
            //dd($hearing);


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
    public function show(Hearing $hearing)
    {
        return response()->json($hearing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HearingRequest $request, Hearing $hearing)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {

            $hearing->informed_client = ($request->informed_client ? 's' : 'n');
            $hearing->informed_witnesses = ($request->informed_witnesses ? 's' : 'n');
            $hearing->object = $request->object;
            $hearing->responsible = $request->responsible;
            $hearing->status = $request->status;
            $hearing->date_happen = $request->date_happen;
            $hearing->time_happen = $request->time_happen;
            $hearing->external_office_id = $request->external_office_id;
            $hearing->client = $request->client;
            $hearing->local = $request->local;
            $hearing->type = $request->type;
            $hearing->process_num = $request->process_num;
            $hearing->modality = $request->modality;
            $hearing->link = $request->link;
            $hearing->payment_status = $request->payment_status;
            $hearing->notes = $request->notes;
            $hearing->amount = str_replace([".", ","], ["", "."], $request->amount);
            $hearing->company_id = $request->company_id;
            $hearing->user_id = $request->user_id;
            $hearing->update();
            //dd($hearing);


            //comita depois de tudo ter sido salvo
            DB::commit();

            //Redireciona para outra página após cadastrar com sucesso
            return response()->json( ['success' => 'Registro alterado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hearing $hearing)
    {
        try {
            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            $deleteHearing = Hearing::where('id', $hearing->id)
            ->where('company_id', auth()->user()->company_id)->delete();

            //comita depois de tudo ter sido salvo
            DB::commit();

            return response()->json(['success' => 'Tá aê. Registro excluído com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
