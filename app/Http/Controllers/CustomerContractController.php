<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentTemplateRequest;
use App\Models\CustomerContract;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Http\Request;

class CustomerContractController extends Controller
{
    private $helperAdm;

    public function __construct(\HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentTemplateRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {

            $document = new CustomerContract;
            $document->title = $request->title;
            $document->content = $request->content;
            $document->customer_id = $request->customer_id;
            $document->type = $request->type;
            $document->area = $request->area;
            $document->company_id = $request->company_id;
            $document->save();

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
    public function show(CustomerContract $customerContract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerContract $customerContract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerContract $customerContract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerContract $customerContract)
    {
        //
    }
}
