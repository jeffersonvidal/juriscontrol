<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalPetitionRequest;
use App\Models\ExternalOffice;
use App\Models\ExternalPetition;
use App\Http\Controllers\Controller;
use App\Models\TypePetition;
use App\Models\User;
use App\Models\Wallet;
use DB;
use Exception;
use Illuminate\Http\Request;

class ExternalPetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $externalPetitions = ExternalPetition::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)
        ->orderBy('name', 'ASC')->get();
        
        $users = User::where('company_id', auth()->user()->company_id)
        ->orderBy('name', 'ASC')->get();
        
        $wallets = Wallet::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();
        
        $typePetitions = TypePetition::where('company_id', auth()->user()->company_id)
        ->orderBy('name', 'ASC')->get();

        return view('external_petitions.index', [
            'externalPetitions' => $externalPetitions,
            'externalOffices' => $externalOffices,
            'wallets' => $wallets,
            'users' => $users,
            'typePetitions' => $typePetitions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExternalPetitionRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {

            $externalPetition = new ExternalPetition;
            $externalPetition->wallet_id = $request->wallet_id;
            $externalPetition->user_id = $request->user_id;
            $externalPetition->company_id = $request->company_id;
            $externalPetition->external_office_id = $request->external_office_id;
            $externalPetition->responsible = $request->responsible;
            $externalPetition->delivery_date = $request->delivery_date;
            $externalPetition->type = $request->type;
            $externalPetition->customer_name = $request->customer_name;
            $externalPetition->process_number = $request->process_number;
            $externalPetition->court = $request->court;
            $externalPetition->notes = $request->notes;
            $externalPetition->amount = $request->amount;
            $externalPetition->status = 'started';
            $externalPetition->payment_status = "pending";
            $externalPetition->save();

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
    public function show(ExternalPetition $externalPetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalPetition $externalPetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalPetition $externalPetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalPetition $externalPetition)
    {
        //
    }
}
