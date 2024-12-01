<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\SelfCustomerRequest;
use App\Models\Company;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\CustomerContract;
use App\Models\DocumentTemplate;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Google\Client as GoogleClient;
use Google\Service\Drive;
use HelpersAdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;

class CustomerController extends Controller
{
    private $helperAdm;

    public function __construct(\HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    public function index(){
        $customers = Customer::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();
        $customersAddr = CustomerAddress::where('company_id', auth()->user()->company_id)->get();

        //Carrega a view
        return view('customers.index', ['customers' => $customers, 'customersAddr' => $customersAddr]);
    }

    public function history(Customer $customer){
        /**Retorna endereço do cliente */
        $customerAddress = CustomerAddress::with('customer')
            ->where('customer_id', $customer->id)
            ->orderBy('main',  'DESC')->get();
        
        /**Retorna Documentos */
        $documentTemplates = DocumentTemplate::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        /**Helper Adm */
        $helper = new HelpersAdm;

        // Montar cabeçalho de documentos com os dados do cliente
        $clientHeaderDocs = $helper->mountClientHeaderDocs($customer, $customerAddress->first());

        /**Retorna todos os documentos do cliente */
        $customerDocuments = CustomerContract::where('customer_id', $customer->id)
        ->where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        /**Retorna documento preenchido com os dados do cliente */
        


            //return view
            return view('customers.history', [
                'customer' => $customer,
                'customerAddress' => $customerAddress, 
                'documentTemplates' => $documentTemplates, 
                'clientHeaderDocs' => $clientHeaderDocs,
                'customerDocuments' => $customerDocuments,
                'helper' => $this->helperAdm,
            ]);
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
        // $customerAddress = CustomerAddress::with('customer')
        //     ->where('customer_id', $customer->id)
        //     ->orderBy('created_at')
        //     ->get();

        // //return response()->json($theCustomer);
        // return response()->json([$customerAddress]);
        $customer->load('address');
        return response()->json($customer);
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
            $customer->name = $this->helperAdm->setUppercase($request->name);
            $customer->company_id = $request->company_id;
            $customer->email = $this->helperAdm->setLowercase($request->email);
            $customer->phone = $this->helperAdm->limpaCampo($request->phone);
            $customer->rg = $this->helperAdm->limpaCampo($request->rg);
            $customer->rg_expedidor = $this->helperAdm->setUppercase($request->rg_expedidor);
            $customer->cpf = $this->helperAdm->limpaCampo($request->cpf);
            $customer->marital_status = $request->marital_status;
            $customer->nationality = $request->nationality;
            $customer->profession = $request->profession;
            $customer->birthday = $request->birthday;
            $customer->met_us = $request->met_us;
            $customer->save();

            $customerAddress = new CustomerAddress();
            $customerAddress->zipcode = $this->helperAdm->limpaCampo($request->zipcode);
            $customerAddress->street = $request->street;
            $customerAddress->num = $request->num;
            $customerAddress->complement = $request->complement;
            $customerAddress->neighborhood = $request->neighborhood;
            $customerAddress->city = $request->city;
            $customerAddress->state = $request->state;
            $customerAddress->company_id = $request->company_id;
            //$customerAddress->customer_id = $customer->id;
            $customer->address()->save($customerAddress);

            /**Configuração no Google Drive */
            $company = Company::where('id', auth()->user()->company_id)->first();
            $client = new GoogleClient();
            // $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            // $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
            // $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
            $client->setClientId($company->gdrive_client_id);
            $client->setClientSecret($company->gdrive_client_secret);
            $client->refreshToken($company->gdrive_refresh_token);
            
            $driveService = new Drive($client);

            // Nome da pasta a ser criada
            $folderName = strtoupper($customer->name);
            /**Pasta Pai (clientes) no drive */
            $parentFolderId = $company->gdrive_customers_folder;

            // Criar a pasta no Google Drive
            $folderMetadata = new Drive\DriveFile(array(
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => array($parentFolderId)
            ));
            
            $folder = $driveService->files->create($folderMetadata, array(
                'fields' => 'id'
            ));

            /**Atualiza o campo gdrive_folder_id na tabela de clientes */
            $customer->gdrive_folder_id = $folder->id;
            $customer->update();

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
        //dd($request);
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $customer->name = $this->helperAdm->setUppercase($request->name);
            $customer->company_id = $request->company_id;
            $customer->email = $this->helperAdm->setLowercase($request->email);
            $customer->phone = $this->helperAdm->limpaCampo($request->phone);
            $customer->rg = $this->helperAdm->limpaCampo($request->rg);
            $customer->rg_expedidor = $this->helperAdm->setUppercase($request->rg_expedidor);
            $customer->cpf = $this->helperAdm->limpaCampo($request->cpf);
            $customer->marital_status = $request->marital_status;
            $customer->nationality = $request->nationality;
            $customer->profession = $request->profession;
            $customer->birthday = $request->birthday;
            $customer->met_us = $request->met_us;
            $customer->update();

            /**Verifica se o cliente tem endereço cadastrado */
            $getCustomerAddress = CustomerAddress::where('customer_id', $customer->id);
            if($getCustomerAddress->exists()){
                $editCustomerAddress = CustomerAddress::where('customer_id', $customer->id)
                ->where('company_id', auth()->user()->company_id)->update([
                    'zipcode' => $this->helperAdm->limpaCampo($request->zipcode),
                    'street' => $request->street,
                    'num' => $request->num,
                    'complement' => $request->complement,
                    'neighborhood' => $request->neighborhood,
                    'city' => $request->city,
                    'state' => $request->state,
                    'company_id' => $request->company_id,
                ]);
            }else{
                $customerAddress = new CustomerAddress();
                $customerAddress->customer_id = $customer->id;
                $customerAddress->zipcode = $this->helperAdm->limpaCampo($request->zipcode);
                $customerAddress->street = $request->street;
                $customerAddress->num = $request->num;
                $customerAddress->complement = $request->complement;
                $customerAddress->neighborhood = $request->neighborhood;
                $customerAddress->city = $request->city;
                $customerAddress->state = $request->state;
                $customerAddress->company_id = $request->company_id;
                $customerAddress->save();
            }

            

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

    /**Próprio cliente preenche os dados em formulário fora do sistema através de link enviado pelo whatsapp */
    public function createSelf(){
        //Carrega a view
        return view('customers.selfCreate');
    }

    /**Salvar cadastro de cliente feito por ele mesmo */
    public function storeSelf(SelfCustomerRequest $request, Company $company){
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            //Model da tabela - campos a serem salvos
            $customer = new Customer();
            $customer->name = $this->helperAdm->setUppercase($request->name);
            $customer->company_id = $company->id;
            $customer->email = $this->helperAdm->setLowercase($request->email);
            $customer->phone = $this->helperAdm->limpaCampo($request->phone);
            $customer->rg = $this->helperAdm->limpaCampo($request->rg);
            $customer->rg_expedidor = $this->helperAdm->setUppercase($request->rg_expedidor);
            $customer->cpf = $this->helperAdm->limpaCampo($request->cpf);
            $customer->marital_status = $request->marital_status;
            $customer->nationality = $request->nationality;
            $customer->profession = $request->profession;
            $customer->birthday = $request->birthday;
            $customer->met_us = $request->met_us;
            $customer->save();

            $customerAddress = new CustomerAddress();
            $customerAddress->zipcode = $this->helperAdm->limpaCampo($request->zipcode);
            $customerAddress->street = $request->street;
            $customerAddress->num = $request->num;
            $customerAddress->complement = $request->complement;
            $customerAddress->neighborhood = $request->neighborhood;
            $customerAddress->city = $request->city;
            $customerAddress->state = $request->state;
            $customerAddress->company_id = $request->company_id;
            $customer->address()->save($customerAddress);

            /**Configuração no Google Drive */
            $client = new GoogleClient();
            $client->setClientId($company->gdrive_client_id);
            $client->setClientSecret($company->gdrive_client_secret);
            $client->refreshToken($company->gdrive_refresh_token);
            
            $driveService = new Drive($client);

            // Nome da pasta a ser criada
            $folderName = strtoupper($customer->name);
            /**Pasta Pai (clientes) no drive */
            $parentFolderId = $company->gdrive_customers_folder;

            // Criar a pasta no Google Drive
            $folderMetadata = new Drive\DriveFile(array(
                'name' => $folderName,
                'mimeType' => 'application/vnd.google-apps.folder',
                'parents' => array($parentFolderId)
            ));
            
            $folder = $driveService->files->create($folderMetadata, array(
                'fields' => 'id'
            ));

            /**Atualiza o campo gdrive_folder_id na tabela de clientes */
            $customer->gdrive_folder_id = $folder->id;
            $customer->update();

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


    /**Gerar PDFs */   
    public function createPDF($documentId)
    {
        // Encontre o contrato do cliente com base no ID do documento
        $customerContract = CustomerContract::where('id', $documentId)
            ->where('company_id', auth()->user()->company_id)
            ->firstOrFail();
    
        // Encontre o cliente com base no ID do cliente no contrato
        $customer = Customer::where('id', $customerContract->customer_id)->firstOrFail();
    
        // Encontre o PDF do documento correspondente ao contrato do cliente
        $documentPDF = CustomerContract::where('id', $customerContract->id)
            ->where('company_id', auth()->user()->company_id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();
    
        // Opções do dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
    
        // Renderize a view principal do PDF
        $pdf = Pdf::loadView('customers.create_pdf', [
            'documentPDF' => $documentPDF,
            'headerImagePath' => public_path('imgs/headerDocsBV.png')
        ])->setPaper('a4', 'portrait');
    
        return $pdf->stream();
    }
    
    
    
    
    
    
    


}/**fim da classe */
