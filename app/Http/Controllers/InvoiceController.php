<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\InvoiceCategory;
use App\Models\Wallet;
use Carbon\Carbon;
use Exception;
use HelpersAdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
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
        $invoices = Invoice::when($request->has('nome'), function ($whenQuery) use ($request){
            $whenQuery->where('description', 'like', '%' . $request->nome . '%');
        })
        ->when($request->has('data_inicio'), function ($whenQuery) use ($request){
            $whenQuery->where('due_at', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
        })
        ->when($request->has('data_fim'), function ($whenQuery) use ($request){
            $whenQuery->where('due_at', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
        })
        ->where('company_id', auth()->user()->company_id)
        ->where('status', '!=', 'paid')
        ->orderBy('due_at', 'ASC')
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
        return view('invoices.index', [
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
    public function store(InvoiceRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {

            $invoice = new Invoice;
            $invoice->invoice_of = null;
            $invoice->type = $request->type;
            $invoice->amount = str_replace([".", ","], ["", "."], $request->amount);
            //$invoice->amount = number_format($request->amount, 2, ',', '.');
            $invoice->period = ($request->period == null ? $request->period : "month");
            $invoice->enrollments = ($request->enrollments ?: 1);
            $invoice->enrollment_of = 1;
            $invoice->description = $request->description;
            $invoice->due_at = $request->due_at;
            $invoice->wallet_id = $request->wallet_id;
            $invoice->invoice_category_id = $request->invoice_category_id;
            $invoice->repeat_when = $request->repeat_when;
            $invoice->company_id = $request->company_id;
            $invoice->user_id = auth()->user()->id;
            $invoice->status = "unpaid";

            /** Verifica se a repetição é única */
            if($request->repeat_when == "unique" || $request->repeat_when == "fixed"){
                $enrollments = 1;
                //Model da tabela - campos a serem salvos
                $invoice->save();
            }

            /**Verifica se tem parcelas e já lança as parcelas no banco de dados */
            if($request->repeat_when == "enrollment"){
                
                /**Em caso de parcelamento */
                $vencimento = strtotime($request->due_at);
                $enrollment_amount = ($request->amount / $request->enrollments);
                
                //Model da tabela - campos a serem salvos
                $invoice->amount = $enrollment_amount;
                $invoice->save();
                
                $invoiceOf = $invoice->id;
                
                /**Registra as parcelas */
                for($enrollment = 1; $enrollment < $request->enrollments; $enrollment++){
                    $parcela = (new Invoice());
                    $parcela->type = ($request->repeat_when == "fixed" ? "fixed_$request->type" : "$request->type");
                    //$parcela->period = ($request->period ?? "month");
                    $parcela->enrollments = ($request->enrollments ?: 1);
                    $parcela->description = $request->description;
                    $parcela->wallet_id = $request->wallet_id;
                    $parcela->invoice_category_id = $request->invoice_category_id;
                    $parcela->repeat_when = $request->repeat_when;
                    $parcela->company_id = $request->company_id;
                    $parcela->user_id = auth()->user()->id;

                    $vencimento = strtotime('+31 days', $vencimento);
                    $parcela->invoice_of = $invoiceOf;
                    //$vencimento = strtotime('+' .$enrollment. ' month', $vencimento);
                    $parcela->due_at = date('Y-m-d', $vencimento);
                    //$parcela->status = (date($parcela->due_at) <= date("Y-m-d") ? "paid" : "unpaid");
                    $parcela->status = "unpaid";
                    $parcela->amount = $enrollment_amount;
                    $parcela->enrollment_of = $enrollment + 1;

                    $parcela->save();
                }
            }

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
    public function show(Invoice $invoice)
    {
        //$theInvoice = Invoice::find($invoice)->first();
        //return response()->json($theInvoice);
        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            
            
            $editInvoice = Invoice::where('id', $invoice->id)
            ->where('company_id', auth()->user()->company_id)->update([
                'invoice_of' => $request->invoice_of,
                'type' => $request->type,
                'amount' => str_replace([".", ","], ["", "."], $request->amount),
                'period' => ($request->period == null ? $request->period : "month"),
                'enrollments' => ($request->enrollments ?: 1),
                'enrollment_of' => 1,
                'description' => $request->description,
                'due_at' => $request->due_at,
                'wallet_id' => $request->wallet_id,
                'invoice_category_id' => $request->invoice_category_id,
                'repeat_when' => $request->repeat_when,
                'company_id' => $request->company_id,
                'user_id' => auth()->user()->id,
                'status' => "unpaid",
            ]);

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
    public function destroy(Invoice $invoice)
    {
        try {
            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            //$deleteUser = User::where('id', $user)->delete();
            $deleteInvoice = Invoice::where('id', $invoice->id)
            ->where('company_id', auth()->user()->company_id)->delete();

            //comita depois de tudo ter sido salvo
            DB::commit();

            return response()->json(['success' => 'Registro excluído com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
