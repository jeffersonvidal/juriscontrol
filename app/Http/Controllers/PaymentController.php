<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Invoice;
use App\Models\InvoiceCategory;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Carbon\Carbon;
use DB;
use Exception;
use HelpersAdm;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $helperAdm;
    private $modelFunctions;
    private $modelPayment;

    public function __construct(HelpersAdm $helpersAdm, Invoice $invoice, Payment $payment){
        $this->helperAdm = $helpersAdm;
        $this->modelFunctions = $invoice;
        $this->modelPayment = $payment;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**Pega todas as wallets da empresa */
        $wallets = Wallet::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        /**Pega todos os registros inclusive na busca personalizada */
        $payments = Payment::when($request->has('data_inicio'), function ($whenQuery) use ($request){
            $whenQuery->where('pay_day', '>=', Carbon::parse($request->data_inicio)->format('Y-m-d'));
        })
        ->when($request->has('data_fim'), function ($whenQuery) use ($request){
            $whenQuery->where('pay_day', '<=', Carbon::parse($request->data_fim)->format('Y-m-d'));
        })
        ->where('company_id', auth()->user()->company_id)
        ->where('status', 'paid')
        ->orderBy('created_at', 'DESC')
        ->get();

        $invoices = Invoice::where('company_id', auth()->user()->company_id)->get();

        /**Somar receitas do mês corrente */
        $mes = $this->modelFunctions->getCurrentNumberMonth();
        $ano = $this->modelFunctions->getCurrentNumberYear();
        $inicioMes = Carbon::create($ano, $mes, 1);
        $fimMes = $inicioMes->copy()->endOfMonth();
        $receitaMensal = Invoice::whereBetween('due_at', [$inicioMes, $fimMes])
            ->where('company_id', auth()->user()->company_id)
            ->where('type', 'income')->sum('amount');

        /**Somar Despesas do mês corrente */
        $despesaMensal = Invoice::whereBetween('due_at', [$inicioMes, $fimMes])
            ->where('company_id', auth()->user()->company_id)
            ->where('type', 'expense')->sum('amount');

        /**Somar todas as despesas pagas */
        $despesasTotal = Invoice::where('status', '=', 'paid')
            ->where('company_id', auth()->user()->company_id)
            ->where('type', 'expense')->sum('amount');

        /**Somar todas as receitas pagas */
        $receitasTotal = Invoice::where('status', '=', 'paid')
            ->where('company_id', auth()->user()->company_id)
            ->where('type', 'income')->sum('amount');
        
        /**Contabiliza saldo em caixa */
        $saldoCaixa = ($receitasTotal - $despesasTotal);

        /**Categorias das Faturas */
        $invoiceCategories = InvoiceCategory::where('company_id', auth()->user()->company_id)
            ->orderBy('name', 'ASC')
            ->get();

        

        /**Pega as funções do helper */
        $helper = new HelpersAdm;

        //Carrega a view
        return view('payments.index', [
            'payments' => $payments,
            'invoices' => $invoices,
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'wallets' => $wallets,
            'mesAtual' => $helper->getMonth(),
            'receitaMes' => $receitaMensal,
            'despesaMes' => $despesaMensal,
            'saldoCaixa' => $saldoCaixa,
            'invoiceCategories' => $invoiceCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            /**Calcula valor restante em caso de abatimento da conta */
            $amount_remaining = ($request->amount_owed - $request->amount_paid);
            $status = ($amount_remaining > 0) ? 'partial' : $request->status;
            $amount_owed = ($amount_remaining > 0) ? str_replace([".", ","], ["", "."], $amount_remaining) : str_replace([".", ","], ["", "."], $request->amount_owed);
            /**Trata os dados para salvar no banco de dados */
            $payment = new Payment;
            $payment->amount_owed = $request->amount_owed;
            $payment->wallet_id = $request->wallet_id;
            $payment->pay_day = $request->pay_day;
            $payment->amount_paid = str_replace([".", ","], ["", "."], $request->amount_paid);
            $payment->enrollment_of = $request->enrollment_of;
            $payment->method = $request->method;
            $payment->company_id = $request->company_id;
            $payment->user_id = auth()->user()->id;
            $payment->invoice_id = $request->invoice_id;
            $payment->status = $request->status;
            $payment->amount_remaining = str_replace([".", ","], ["", "."], $amount_remaining);
            $payment->save();  

            //dd($payment);
            
            $editInvoice = Invoice::where('id', $payment->invoice_id)
            ->where('company_id', auth()->user()->company_id)->update([
                'status' => $status,
                'amount' => $amount_owed,
            ]);

            //comita depois de tudo ter sido salvo
            DB::commit();

            //Redireciona para outra página após cadastrar com sucesso
            return response()->json( ['success' => 'Pagamento lançado com sucesso!']);
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
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //atualizar o status na fatura(invoice), petição e audiência de parceiros
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
