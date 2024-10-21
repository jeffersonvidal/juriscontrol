<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerAddressRequest;
use App\Models\CustomerAddress;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
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
    public function store(CustomerAddressRequest $request)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //Model da tabela - campos a serem salvos
            $customerAddress = new CustomerAddress();
            $customerAddress->zipcode = $this->helperAdm->limpaCampo($request->zipcode);
            $customerAddress->street = $request->street;
            $customerAddress->num = $request->num;
            $customerAddress->complement = $request->complement;
            $customerAddress->neighborhood = $request->neighborhood;
            $customerAddress->city = $request->city;
            $customerAddress->state = $request->state;
            $customerAddress->company_id = $request->company_id;
            $customerAddress->customer_id = $request->customer_id;

            if($request->main == 1){
                /**Verifica se já existe algum endereço como principal */
                $mainAddr = CustomerAddress::where('company_id', auth()->user()->company_id)
                ->where('customer_id', $request->customer_id)->first();
                if($mainAddr){
                    /**Atualiza o endereço anterior o campo main para 0 (zero) */
                    $mainAddr->main = 0;
                    $mainAddr->update();
                }
            }

            
            $customerAddress->main = $request->main;
            $customerAddress->save();

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
    public function show(CustomerAddress $customerAddress)
    {
        $customerAddress = CustomerAddress::where('customer_id', $customerAddress->id)
            ->orderBy('created_at')
            ->get();

        //return response()->json($theCustomer);
        return response()->json([$customerAddress]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerAddressRequest $request, CustomerAddress $customerAddress)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $customerAddress->zipcode = $this->helperAdm->limpaCampo($request->zipcode);
            $customerAddress->street = $request->street;
            $customerAddress->num = $request->num;
            $customerAddress->complement = $request->complement;
            $customerAddress->neighborhood = $request->neighborhood;
            $customerAddress->city = $request->city;
            $customerAddress->state = $request->state;
            $customerAddress->company_id = $request->company_id;

            if($request->main == 1){
                /**Verifica se já existe algum endereço como principal */
                $mainAddr = CustomerAddress::where('company_id', auth()->user()->company_id)
                ->where('customer_id', $request->customer_id)
                ->where('main', '=', 1)->first();
                if($mainAddr){
                    /**Atualiza o endereço anterior o campo main para 0 (zero) */
                    $mainAddr->main = 0;
                    $mainAddr->update();
                }
            }

            $customerAddress->main = $request->main;
            $customerAddress->update();

            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json($customer);
            return response()->json(['success' => 'Registro alterado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Redireciona para outra página se der erro
            return response()->json(['error' => $e->getMessage()]);
            //return back()->withInput()->with('error', 'Erro ao cadastrar registro!<br>Tente novamente! Du doido<br>'.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerAddress $customerAddress)
    {
        //dd($customerAddress);
        if($customerAddress->main == 1){
            /**Verifica se já existe algum endereço como principal */
            $mainAddr = CustomerAddress::where('company_id', auth()->user()->company_id)
            ->where('customer_id', $customerAddress->customer_id)
            ->where('main', '=', 0)->first();
            if($mainAddr){
                /**Atualiza o endereço anterior o campo main para 0 (zero) */
                $mainAddr->main = 1;
                $mainAddr->update();
            }
        }

        // $theAddress = CustomerAddress::where('id',$customerAddress)->delete();
        $customerAddress->delete();
        return response()->json(null, 204);
    }
}
