<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerDocumentRequest;
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
        $theDocument = CustomerContract::where('id',$customerContract)->first();
        //return response()->json($theLabel);
        return response()->json($theDocument);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerDocumentRequest $request, CustomerContract $customerContract)
    {
        //dd($customerContract);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $editDocument = CustomerContract::where('id', $customerContract->id)
            ->where('company_id', auth()->user()->company_id)->update([
                'title' => $request->title,
                'content' => $request->content,
                'customer_id' => $request->customer_id,
                'type' => $request->type,
                'area' => $request->area,
                'company_id' => $request->company_id,
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
    public function destroy(CustomerContract $customerContract)
    {
        $customerContract->delete();
        return response()->json(null, 204);
    }
}
