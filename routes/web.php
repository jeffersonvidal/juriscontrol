<?php

use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentTemplateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExternalOfficeController;
use App\Http\Controllers\ExternalPetitionController;
use App\Http\Controllers\HearingController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LegalProcessController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\ExternalOffice;
use Illuminate\Support\Facades\Route;

/** Rota url padrão/raiz */
// Route::get('/', function () {
//     return view('welcome');
// });

/**Rotas Públicas */

/**Rota de login */
Route::get('/', [LoginController::class, 'index'])->name('login.index'); //Carrega form de login na url raiz
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process'); //faz processamento dos dados inseridos no form de login e redireciona para dashboard
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy'); //faz processamento dos dados inseridos no form de login e redireciona para dashboard

/**Formulário de cadastro de cliente - próprio cliente preenche os dados */
/**Rotas de Clientes */
Route::get('/create-customer-self/{company}', [CustomerController::class, 'createSelf'])->name('customers.create-self'); //Listar todos os registros da tabela
Route::post('/store-customer-self/{company}', [CustomerController::class, 'storeSelf'])->name('customers.store-self'); //Salva novo registro no BD


/**Rotas Privadas - Restringindo acesso às páginas do sistema para quem não estiver logado */
Route::group(['middleware' => 'auth'], function(){

  /**Rota raiz do painel de controle do sistema */
  Route::get('/index-dashboard', [DashboardController::class,'index'])->name('dashboard.index');

  /**Rotas de usuários */
  Route::get('/index-user', [UserController::class, 'index'])->name('users.index'); //Listar todos os registros da tabela
  Route::get('/show-user/{user}', [UserController::class, 'show'])->name('users.show'); //Mostra detalhe de um registro
  Route::post('/store-user', [UserController::class, 'store'])->name('users.store'); //Salva novo registro no BD
  Route::put('/update-user/{user}', [UserController::class, 'update'])->name('users.update'); //Atualiza um registro no BD
  Route::get('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('users.update-password'); //Atualiza um registro no BD
  Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('users.destroy'); //Exclui um registro no BD

  /**Rotas de Etiquetas */
  Route::get('/index-label', [LabelController::class, 'index'])->name('labels.index'); //Listar todos os registros da tabela
  Route::get('/show-label/{label}', [LabelController::class, 'show'])->name('labels.show'); //Mostra detalhe de um registro
  Route::get('/create-label', [LabelController::class, 'create'])->name('labels.create'); //Carrega form para novo cadastro
  Route::post('/store-label', [LabelController::class, 'store'])->name('labels.store'); //Salva novo registro no BD
  Route::get('/edit-label/{label}', [LabelController::class, 'edit'])->name('labels.edit'); //Carrega form para atualizar um registro
  Route::put('/update-label/{label}', [LabelController::class, 'update'])->name('labels.update'); //Atualiza um registro no BD
  Route::delete('/destroy-label/{label}', [LabelController::class, 'destroy'])->name('labels.destroy'); //Exclui um registro no BD

  /**Rotas de Tarefas */
  Route::get('/index-task', [TaskController::class, 'index'])->name('tasks.index'); //Listar todos os registros da tabela
  Route::get('/show-task/{task}', [TaskController::class, 'show'])->name('tasks.show'); //Mostra detalhe de um registro
  Route::get('/create-task', [TaskController::class, 'create'])->name('tasks.create'); //Carrega form para novo cadastro
  Route::post('/store-task', [TaskController::class, 'store'])->name('tasks.store'); //Salva novo registro no BD
  Route::put('/update-task/{task}', [TaskController::class, 'update'])->name('tasks.update'); //Atualiza um registro no BD
  Route::delete('/destroy-task/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy'); //Exclui um registro no BD

  /**Rotas de Clientes */
  Route::get('/index-customer', [CustomerController::class, 'index'])->name('customers.index'); //Listar todos os registros da tabela
  Route::get('/index-history/{customer}', [CustomerController::class, 'history'])->name('customers.history'); //Listar todos os registros da tabela
  Route::get('/show-customer/{customer}', [CustomerController::class, 'show'])->name('customers.show'); //Mostra detalhe de um registro
  Route::post('/store-customer', [CustomerController::class, 'store'])->name('customers.store'); //Salva novo registro no BD
  Route::put('/update-customer/{customer}', [CustomerController::class, 'update'])->name('customers.update'); //Atualiza um registro no BD
  Route::delete('/destroy-customer/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy'); //Exclui um registro no BD

  /**Rotas de Endereços de Clientes */
  Route::get('/index-customer-address', [CustomerAddressController::class, 'index'])->name('customer-addresses.index'); //Listar todos os registros da tabela
  Route::get('/show-customer-address/{customerAddress}', [CustomerAddressController::class, 'show'])->name('customer-addresses.show'); //Mostra detalhe de um registro
  Route::post('/store-customer-address', [CustomerAddressController::class, 'store'])->name('customer-addresses.store'); //Salva novo registro no BD
  Route::put('/update-customer-address/{customerAddress}', [CustomerAddressController::class, 'update'])->name('customer-addresses.update'); //Atualiza um registro no BD
  Route::delete('/destroy-customer-address/{customerAddress}', [CustomerAddressController::class, 'destroy'])->name('customer-addresses.destroy'); //Exclui um registro no BD

  /**Rotas de Escritórios Externos */
  Route::get('/index-external-office', [ExternalOfficeController::class, 'index'])->name('external-offices.index'); //Listar todos os registros da tabela
  Route::get('/show-external-office/{externalOffice}', [ExternalOfficeController::class, 'show'])->name('external-offices.show'); //Mostra detalhe de um registro
  Route::post('/store-external-office', [ExternalOfficeController::class, 'store'])->name('external-offices.store'); //Salva novo registro no BD
  Route::put('/update-external-office/{externalOffice}', [ExternalOfficeController::class, 'update'])->name('external-offices.update'); //Atualiza um registro no BD
  Route::delete('/destroy-external-office/{externalOffice}', [ExternalOfficeController::class, 'destroy'])->name('external-offices.destroy'); //Exclui um registro no BD

  /**Rotas de Faturas (Invoices) */
  Route::get('/index-invoice', [InvoiceController::class, 'index'])->name('invoices.index'); //Listar todos os registros da tabela
  Route::get('/show-invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show'); //Mostra detalhe de um registro
  Route::post('/store-invoice', [InvoiceController::class, 'store'])->name('invoices.store'); //Salva novo registro no BD
  Route::put('/update-invoice/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update'); //Atualiza um registro no BD
  Route::delete('/destroy-invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy'); //Exclui um registro no BD
  
  /**Rotas para Pagamentos */
  Route::get('/index-payment', [PaymentController::class, 'index'])->name('payments.index'); //Listar todos os registros da tabela
  Route::post('/store-payment', [PaymentController::class, 'store'])->name('payments.store'); //Salva novo registro no BD

  /**Rotas de ExternalPetitions (Petições Externas) */
  Route::get('/index-external-petition', [ExternalPetitionController::class, 'index'])->name('external-petitions.index'); //Listar todos os registros da tabela
  Route::get('/show-external-petition/{externalPetition}', [ExternalPetitionController::class, 'show'])->name('external-petitions.show'); //Mostra detalhe de um registro
  Route::post('/store-external-petition', [ExternalPetitionController::class, 'store'])->name('external-petitions.store'); //Salva novo registro no BD
  Route::put('/update-external-petition/{externalPetition}', [ExternalPetitionController::class, 'update'])->name('external-petitions.update'); //Atualiza um registro no BD
  Route::delete('/destroy-external-petition/{externalPetition}', [ExternalPetitionController::class, 'destroy'])->name('external-petitions.destroy'); //Exclui um registro no BD

  /**Rotas de Hearings (Audiências, Reuniões, Diligências) */
  Route::get('/index-hearing', [HearingController::class, 'index'])->name('hearings.index'); //Listar todos os registros da tabela
  Route::get('/show-hearing/{hearing}', [HearingController::class, 'show'])->name('hearings.show'); //Mostra detalhe de um registro
  Route::post('/store-hearing', [HearingController::class, 'store'])->name('hearings.store'); //Salva novo registro no BD
  Route::put('/update-hearing/{hearing}', [HearingController::class, 'update'])->name('hearings.update'); //Atualiza um registro no BD
  Route::delete('/destroy-hearing/{hearing}', [HearingController::class, 'destroy'])->name('hearings.destroy'); //Exclui um registro no BD

  /**Rotas de Legal Processes (Processos Jurídicos) */
  Route::get('/index-legal-process', [LegalProcessController::class, 'index'])->name('legal-processes.index'); //Listar todos os registros da tabela
  Route::get('/search-legal-process', [LegalProcessController::class, 'search'])->name('legal-processes.search'); //Mostra detalhe de um registro
  Route::get('/show-legal-process/{legalProcess}', [LegalProcessController::class, 'show'])->name('legal-processes.show'); //Mostra detalhe de um registro
  Route::post('/store-legal-process', [LegalProcessController::class, 'store'])->name('legal-processes.store'); //Salva novo registro no BD
  Route::put('/update-legal-process/{legalProcess}', [LegalProcessController::class, 'update'])->name('legal-processes.update'); //Atualiza um registro no BD
  Route::delete('/destroy-legal-process/{legalProcess}', [LegalProcessController::class, 'destroy'])->name('legal-processes.destroy'); //Exclui um registro no BD

  /**Rotas de Document Templates (Modelos de Documentos) */
  Route::get('/index-document-templates', [DocumentTemplateController::class, 'index'])->name('document-templates.index'); //Listar todos os registros da tabela
  Route::get('/show-document-templates/{documentTemplate}', [DocumentTemplateController::class, 'show'])->name('document-templates.show'); //Mostra detalhe de um registro
  Route::post('/store-document-templates', [DocumentTemplateController::class, 'store'])->name('document-templates.store'); //Salva novo registro no BD
  Route::put('/update-document-templates/{documentTemplate}', [DocumentTemplateController::class, 'update'])->name('document-templates.update'); //Atualiza um registro no BD
  Route::delete('/destroy-document-templates/{documentTemplate}', [DocumentTemplateController::class, 'destroy'])->name('document-templates.destroy'); //Exclui um registro no BD

  /**Rotas de Calendar (Agenda integrado com Google Agenda) */
  Route::get('/index-events', [EventController::class, 'index'])->name('events.index'); //Listar todos os registros da tabela
  Route::get('/show-events/{event}', [EventController::class, 'show'])->name('events.show'); //Mostra detalhe de um registro
  Route::post('/store-events', [EventController::class, 'store'])->name('events.store'); //Salva novo registro no BD
  Route::put('/update-events/{event}', [EventController::class, 'update'])->name('events.update'); //Atualiza um registro no BD
  Route::delete('/destroy-events/{event}', [EventController::class, 'destroy'])->name('events.destroy'); //Exclui um registro no BD

  
}); //fim da restrição de acesso para quem não está logado no sistema