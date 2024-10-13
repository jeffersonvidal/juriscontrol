<?php

namespace App\Http\Controllers;

use App\Models\DocumentTemplate;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentTemplateRequest;
use DB;
use Exception;
use Illuminate\Http\Request;

class DocumentTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = DocumentTemplate::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();
        return view('document_templates.index', [
            'documents' => $documents,
        ]);
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

            $document = new DocumentTemplate;
            $document->title = $request->title;
            $document->content = $request->content;
            $document->author_id = auth()->user()->id;
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
    public function show(DocumentTemplate $documentTemplate)
    {
        $theDocument = DocumentTemplate::where('id',$documentTemplate)->first();
        //return response()->json($theLabel);
        return response()->json($theDocument);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentTemplateRequest $request, DocumentTemplate $documentTemplate)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();
        

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $editDocument = DocumentTemplate::where('id', $documentTemplate->id)
            ->where('company_id', auth()->user()->company_id)->update([
                'title' => $request->title,
                'content' => $request->content,
                'type' => $request->type,
                'area' => $request->area,
                'author_id' => $request->author_id,
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
    public function destroy(DocumentTemplate $documentTemplate)
    {
        try {
            //garantir que salve nas duas tabelas do banco de dados
            DB::beginTransaction();

            //$deleteUser = User::where('id', $user)->delete();
            $deleteInvoice = DocumentTemplate::where('id', $documentTemplate->id)
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
