<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalPetitionRequest;
use App\Models\ExternalOffice;
use App\Models\ExternalPetition;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\TypePetition;
use App\Models\User;
use App\Models\Wallet;
use DB;
use Exception;
use HelpersAdm;
use Illuminate\Http\Request;

class ExternalPetitionController extends Controller
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
            $externalPetition->payment_status = "unpaid";
            $externalPetition->save();

            /**Lançado como conta a receber */
            $externalOffice = ExternalOffice::where('id',$externalPetition->type)
            ->where('company_id', $externalPetition->company_id)->first();

            $externalTypePetition = TypePetition::where('id',$externalPetition->external_office_id)
            ->where('company_id', $externalPetition->company_id)->first();

            //$description = $externalTypePetition->name . ' de ' . $externalOffice->name . '. Cliente: ' . $externalPetition->customer_name;
            $description = $externalTypePetition->name . '. Cliente: ' . $externalPetition->customer_name;
            $invoice = new Invoice;
            $invoice->enrollment_of = '1';
            $invoice->external_petition_id = $externalPetition->id;
            $invoice->description = $description;
            $invoice->wallet_id = $externalPetition->wallet_id;
            $invoice->user_id = $externalPetition->user_id;
            $invoice->company_id = $externalPetition->company_id;
            $invoice->invoice_category_id = '7';
            $invoice->type = 'income';
            $invoice->amount = $externalPetition->amount;
            $invoice->due_at = $externalPetition->delivery_date;
            $invoice->repeat_when = 'unique';
            $invoice->enrollments = '1';
            $invoice->status = 'unpaid';
            $invoice->save();

            //dd($externalPetition, $invoice);

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
