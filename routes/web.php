<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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

  /**Rota de usuários */
  Route::get('/index-user', [UserController::class, 'index'])->name('users.index'); //Listar todos os registros da tabela
  Route::get('/show-user/{user}', [UserController::class, 'show'])->name('users.show'); //Mostra detalhe de um registro
  Route::post('/store-user', [UserController::class, 'store'])->name('users.store'); //Salva novo registro no BD
  Route::get('/update-user/{user}', [UserController::class, 'update'])->name('users.update'); //Atualiza um registro no BD
  Route::get('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('users.update-password'); //Atualiza um registro no BD
  Route::get('/destroy-user/{user}', [UserController::class, 'destroy'])->name('users.destroy'); //Exclui um registro no BD

}); //fim da restrição de acesso para quem não está logado no sistema