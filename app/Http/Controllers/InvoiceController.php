<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Wallet;
use HelpersAdm;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $helperAdm;

    public function __construct(\HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $invoices = Invoice::where('company_id', auth()->user()->company_id)
        // ->orderBy('id', 'DESC')->get();
        
        $wallets = Wallet::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        //Carrega a view
        // return view('invoices.index', ['invoices' => $invoices, 'wallets' => $wallets]);

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
        ->orderBy('created_at')
        ->get();

        $helper = new HelpersAdm;

        //Carrega a view
        return view('invoices.index', [
            'invoices' => $invoices,
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'wallets' => $wallets,
            'mesAtual' => $helper->getMonth(),
        ]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
