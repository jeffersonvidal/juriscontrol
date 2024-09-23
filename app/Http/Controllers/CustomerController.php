<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
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
        $customerAddress = $customer->customerAddress()->get();
        //return response()->json($theCustomer);
        return response()->json(['customer' => $theCustomer, 'customerAddresses' => $customerAddress]);
    }

    /**Salva registro no banco de dados */
    public function store(CustomerRequest $request)
    {
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //Model da tabela - campos a serem salvos
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->company_id = $request->company_id;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->rg = $request->rg;
            $customer->rg_expedidor = $request->rg_expedidor;
            $customer->cpf = $request->cpf;
            $customer->marital_status = $request->marital_status;
            $customer->nationality = $request->nationality;
            $customer->profession = $request->profession;
            $customer->birthday = $request->birthday;
            $customer->save();

            $customerAddress = new CustomerAddress();
            $customerAddress->zipcode = $request->zipcode;
            $customerAddress->street = $request->street;
            $customerAddress->num = $request->num;
            $customerAddress->complement = $request->complement;
            $customerAddress->neighborhood = $request->neighborhood;
            $customerAddress->city = $request->city;
            $customerAddress->state = $request->state;
            $customerAddress->company_id = $request->company_id;
            $customerAddress->customer_id = $customer->id;

            $customer->address()->save($customerAddress);

            //dd($customer, $customerAddress);

            //dd($customer, $customer->customerAddr()->create($request->all()));

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
