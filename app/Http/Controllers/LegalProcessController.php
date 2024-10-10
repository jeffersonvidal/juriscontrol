<?php

namespace App\Http\Controllers;

use App\ApicnjClass;
use App\Models\LegalProcess;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Http\Request;

class LegalProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('legal_processes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $retornoValidacaoNumero = ApicnjClass::validarNumeroCnj($request);
        //dd($request);

        try {
            if (isset($retornoValidacaoNumero['erro'])) {
                echo $retornoValidacaoNumero['erro'];
                //break;
            };
            
            $retornoApi = apicnjClass::buscarTribunalApi($retornoValidacaoNumero);
            
            if (isset($retornoApi['erro'])) {
                echo $retornoApi['erro'];
                //break;
            };
            
            $retornoDadosProcesso = apicnjClass::consomeApi($retornoApi);
            //dd($retornoDadosProcesso);
            
            if (!empty($retornoDadosProcesso['erro'])) {
                echo $retornoDadosProcesso['erro'];
                //break;
            };

            //Redireciona para outra página após cadastrar com sucesso
            //return response()->json( ['success' => 'Registro cadastrado com sucesso!']);
            return response()->json($retornoDadosProcesso);
            // return view('legal_processes.index',[
            //     'retornoDadosProcesso' => $retornoDadosProcesso,
            // ]);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            //DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
            
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $retornoValidacaoNumero = ApicnjClass::validarNumeroCnj($request);
        //dd($request);

        try {
            if (isset($retornoValidacaoNumero['erro'])) {
                echo $retornoValidacaoNumero['erro'];
                //break;
            };
            
            $retornoApi = apicnjClass::buscarTribunalApi($retornoValidacaoNumero);
            
            if (isset($retornoApi['erro'])) {
                echo $retornoApi['erro'];
                //break;
            };
            
            $retornoDadosProcesso = apicnjClass::consomeApi($retornoApi);
            //dd($retornoDadosProcesso);
            
            if (!empty($retornoDadosProcesso['erro'])) {
                echo $retornoDadosProcesso['erro'];
                //break;
            };

            //Redireciona para outra página após cadastrar com sucesso
            //return response()->json( ['success' => 'Registro cadastrado com sucesso!']);
            return response()->json($retornoDadosProcesso);
            //return view('legal_processes.index', ['retornoDadosProcesso' => $retornoDadosProcesso]);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            //DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LegalProcess $legalProcess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LegalProcess $legalProcess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LegalProcess $legalProcess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LegalProcess $legalProcess)
    {
        //
    }
}
