<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalPetitionRequest;
use App\Models\ExternalOffice;
use App\Models\ExternalPetition;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\TypePetition;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
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
        ->orderBy('payment_status', 'DESC')->get();

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
        $theExternalPetition = ExternalPetition::where('id', $externalPetition)->first();
        //return response()->json($theLabel);
        return response()->json($theExternalPetition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExternalPetitionRequest $request, ExternalPetition $externalPetition, Invoice $invoice, Payment $payment)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {

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
            $externalPetition->status = $request->status;
            $externalPetition->payment_status = $request->payment_status;

            $externalPetition->update();

            /**Atualizando status de pagamento em conta a receber */
            if($externalPetition->payment_status == 'paid'){
                $invoiceStatus = 'paid';

                //dd($externalPetition->company_id);

                /**Pegando a invoice que será editada */
                $editedInvoice = Invoice::where('external_petition_id', $externalPetition->id)
                    ->where('company_id', $externalPetition->company_id)->first();
                    //dd($editedInvoice);
            
                /**Alterando o status da invoice */
                $updateInvoice = Invoice::where('external_petition_id', $externalPetition->id)
                ->where('company_id', $externalPetition->company_id)->update([
                    'status' => $externalPetition->payment_status,
                ]);
                
                /**Registrando pagamento na tabela payments */
                $payment = new Payment;
                $payment->amount_owed = $externalPetition->amount;
                $payment->wallet_id = $externalPetition->wallet_id;
                $payment->pay_day = Carbon::now();
                $payment->amount_paid = str_replace([".", ","], ["", "."], $externalPetition->amount);
                $payment->enrollment_of = 1;
                $payment->method = $request->method;
                $payment->company_id = $externalPetition->company_id;
                $payment->user_id = $externalPetition->user_id;
                $payment->invoice_id = $editedInvoice->id;
                $payment->status = $invoiceStatus;
                $payment->amount_remaining = 0;
                $payment->save(); 
            }
            
//            dd($externalPetition);

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
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalPetition $externalPetition)
    {
        try {
            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            //$deleteUser = User::where('id', $user)->delete();
            $deleteExternalPeition = ExternalPetition::where('id', $externalPetition->id)
            ->where('company_id', auth()->user()->company_id)->delete();

            //comita depois de tudo ter sido salvo
            DB::commit();

            return response()->json(['success' => 'Registro excluído com sucesso - Doido!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
