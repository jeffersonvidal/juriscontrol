<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
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

/**Rotas Privadas - Restringindo acesso às páginas do sistema para quem não estiver logado */
Route::group(['middleware' => 'auth'], function(){

  /**Rota raiz do painel de controle do sistema */
  Route::get('/index-dashboard', [DashboardController::class,'index'])->name('dashboard.index');

  /**Rotas de usuários */
  Route::get('/index-user', [UserController::class, 'index'])->name('users.index'); //Listar todos os registros da tabela
  Route::get('/show-user/{user}', [UserController::class, 'show'])->name('users.show'); //Mostra detalhe de um registro
  Route::post('/store-user', [UserController::class, 'store'])->name('users.store'); //Salva novo registro no BD
  Route::get('/update-user/{user}', [UserController::class, 'update'])->name('users.update'); //Atualiza um registro no BD
  Route::get('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('users.update-password'); //Atualiza um registro no BD
  Route::get('/destroy-user/{user}', [UserController::class, 'destroy'])->name('users.destroy'); //Exclui um registro no BD

  /**Rotas de labels */
  Route::get('/index-label', [LabelController::class, 'index'])->name('labels.index'); //Listar todos os registros da tabela
  Route::get('/show-label/{label}', [LabelController::class, 'show'])->name('labels.show'); //Mostra detalhe de um registro
  Route::get('/create-label', [LabelController::class, 'create'])->name('labels.create'); //Carrega form para novo cadastro
  Route::post('/store-label', [LabelController::class, 'store'])->name('labels.store'); //Salva novo registro no BD
  Route::get('/edit-label/{label}', [LabelController::class, 'edit'])->name('labels.edit'); //Carrega form para atualizar um registro
  Route::put('/update-label/{label}', [LabelController::class, 'update'])->name('labels.update'); //Atualiza um registro no BD
  Route::delete('/destroy-label/{label}', [LabelController::class, 'destroy'])->name('labels.destroy'); //Exclui um registro no BD

  /**Rotas de tasks */
  Route::get('/index-task', [TaskController::class, 'index'])->name('tasks.index'); //Listar todos os registros da tabela
  Route::get('/show-task/{task}', [TaskController::class, 'show'])->name('tasks.show'); //Mostra detalhe de um registro
  Route::get('/create-task', [TaskController::class, 'create'])->name('tasks.create'); //Carrega form para novo cadastro
  Route::get('/store-task', [TaskController::class, 'store'])->name('tasks.store'); //Salva novo registro no BD
  Route::get('/edit-task/{task}', [TaskController::class, 'edit'])->name('tasks.edit'); //Carrega form para atualizar um registro
  Route::get('/update-task/{task}', [TaskController::class, 'update'])->name('tasks.update'); //Atualiza um registro no BD
  Route::get('/destroy-task/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy'); //Exclui um registro no BD


}); //fim da restrição de acesso para quem não está logado no sistema