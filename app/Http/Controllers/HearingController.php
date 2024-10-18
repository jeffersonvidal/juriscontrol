<?php

namespace App\Http\Controllers;

use App\Http\Requests\HearingRequest;
use App\Models\ExternalOffice;
use App\Models\Hearing;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
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

        $wallets = Wallet::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();


        //Carrega a view
        return view('hearings.index', [
            'hearings' => $hearings,
            'users' => $users,
            'externalOffices' => $externalOffices,
            'wallets' => $wallets,
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
            $hearing->wallet_id = $request->wallet_id;
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
            $hearing->payment_status = ($request->payment_status ?: 'unpaid');
            $hearing->notes = $request->notes;
            $hearing->amount = str_replace([".", ","], ["", "."], $request->amount);
            $hearing->company_id = $request->company_id;
            $hearing->user_id = $request->user_id;
            $hearing->external_office_id = $request->external_office_id;
            $hearing->save();
            //dd($hearing);

            /**Lançado como conta a receber */
            $description = $hearing->object . '. Cliente: ' . $hearing->client;
            /**Calculando data de vencimento para pagamento */
            $currentDate = Carbon::now();
            $date_happen = $request->date_happen;
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date_happen);
            $addSevenDays = $carbonDate->addDays(7);
            $due_at = $addSevenDays->format('Y-m-d');
            
            $invoice = new Invoice;
            $invoice->enrollment_of = '1';
            $invoice->external_audience_id = $hearing->id;
            $invoice->description = $description;
            $invoice->wallet_id = $hearing->wallet_id;
            $invoice->user_id = $hearing->user_id;
            $invoice->external_office_id = $hearing->external_office_id;
            $invoice->company_id = $hearing->company_id;
            $invoice->invoice_category_id = '8'; //audiência
            $invoice->type = 'income';
            $invoice->amount = $hearing->amount;
            $invoice->due_at = $due_at;
            $invoice->repeat_when = 'unique';
            $invoice->enrollments = '1';
            $invoice->status = 'unpaid';
            $invoice->save();

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
            $hearing->external_office_id = $request->external_office_id;
            $hearing->update();
            //dd($hearing);

            /**Atualizando status de pagamento em conta a receber */
            if($hearing->payment_status == 'paid'){
                $invoiceStatus = 'paid';

                //dd($hearing->company_id);

                /**Pegando a invoice que será editada */
                $editedInvoice = Invoice::where('external_audience_id', $hearing->id)
                    ->where('company_id', $hearing->company_id)->first();
                    //dd($editedInvoice);
            
                /**Alterando o status da invoice */
                $updateInvoice = Invoice::where('external_audience_id', $hearing->id)
                ->where('company_id', $hearing->company_id)->update([
                    'status' => $hearing->payment_status,
                ]);
                
                /**Registrando pagamento na tabela payments */
                $payment = new Payment;
                $payment->amount_owed = $hearing->amount;
                $payment->wallet_id = $hearing->wallet_id;
                $payment->pay_day = Carbon::now();
                $payment->amount_paid = str_replace([".", ","], ["", "."], $hearing->amount);
                $payment->enrollment_of = 1;
                $payment->method = $request->method;
                $payment->company_id = $hearing->company_id;
                $payment->user_id = $hearing->user_id;
                $payment->invoice_id = $editedInvoice->id;
                $payment->status = $invoiceStatus;
                $payment->amount_remaining = 0;
                $payment->save(); 
            }


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
