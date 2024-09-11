<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/** Rota url padrão/raiz */
Route::get('/', function () {
    return view('welcome');
});

/**Rota de usuários */
Route::get('/index-user', [UserController::class, 'index'])->name('users.index'); //Listar todos os registros da tabela
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('users.show'); //Mostra detalhe de um registro
Route::get('/create-user', [UserController::class, 'create'])->name('users.create'); //Carrega form para novo cadastro
Route::post('/store-user', [UserController::class, 'store'])->name('users.store'); //Salva novo registro no BD
Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('users.edit'); //Carrega form para atualizar um registro
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('users.update'); //Atualiza um registro no BD
Route::get('/edit-user-password/{user}', [UserController::class, 'editPassword'])->name('users.edit-password'); //Carrega form para atualizar um registro
Route::put('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('users.update-password'); //Atualiza um registro no BD
Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('users.destroy'); //Exclui um registro no BD