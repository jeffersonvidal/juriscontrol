<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceCategory;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Carbon\Carbon;
use HelpersAdm;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $helperAdm;
    private $modelFunctions;

    public function __construct(\HelpersAdm $helpersAdm, Invoice $invoice){
        $this->helperAdm = $helpersAdm;
        $this->modelFunctions = $invoice;
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
        ->orderBy('created_at', 'DESC')
        ->get();

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
