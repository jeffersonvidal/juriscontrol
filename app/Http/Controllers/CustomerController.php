<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    private $helperAdm;

    public function __construct(\HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    public function index(){
        $customers = Customer::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        //Carrega a view
        return view('customers.index', ['customers' => $customers]);
    }

    /**Envia registros para popular tabela na index */
    public function getall()
    {
        $customers = Customer::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();
        return response()->json($customers);
    }

    public function show(Customer $customer)
    {
        $theCustomer = Customer::where('id',$customer)->first();
        //return response()->json($theCustomer);
        return response()->json($theCustomer);
    }

    /**Salva registro no banco de dados */
    public function store(CustomerRequest $request)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

    //     ['company_id', 'name','email','phone','rg',
    // 'rg_expedidor','cpf', 'marital_status', 'nationality', 'profession', 'birthday']

        try {
            //Model da tabela - campos a serem salvos
            $customer = Customer::create([
                'name' => $request->name,
                'company_id' => $request->company_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'rg' => $request->rg,
                'rg_expedidor' => $request->rg_expedidor,
                'cpf' => $request->cpf,
                'marital_status' => $request->marital_status,
                'nationality' => $request->nationality,
                'profession' => $request->profession,
                'birthday' => $request->birthday,
            ]);

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

    /**Atualiza registro no banco de dados */
    public function update(CustomerRequest $request, Customer $customer)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $customer->update($request->validated());

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

    /**Exclui registro do banco de dados */
    public function destroy(Customer $customer)
    {
        //$theCustomer = Customer::where('id',$customer)->delete();
        $customer->delete();
        return response()->json(null, 204);
    }
}
