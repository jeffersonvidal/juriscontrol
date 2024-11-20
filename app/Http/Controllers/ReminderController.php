<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReminderRequest;
use Exception;
use Illuminate\Http\Request;
use DB;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReminderRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();

        //garantir que salve nas duas tabelas do banco de dados
        DB::beginTransaction();

        try {
            $reminderData = new Reminder;
            $reminderData->reminder_date = $request->reminder_date;
            $reminderData->responsible_id = $request->responsible_id;
            $reminderData->description = $request->description;
            $reminderData->author_id = $request->author_id;
            $reminderData->company_id = $request->company_id;
            $reminderData->save();

            //dd($userData);
            //comita depois de tudo ter sido salvo
            DB::commit();

            //return response()->json(['success' => true, 'msg' => 'Usuário cadastrado com sucesso!']);
            return response()->json(['success' => 'Lembrete cadastrado com sucesso!']);
        } catch (Exception $e) {
            //Desfazer a transação caso não consiga cadastrar com sucesso no BD
            DB::rollBack();

            //Retorna mensagem de erro ao cadastrar registro no BD
            return response()->json(['error' => $e->getMessage()]);
        }  
    }

    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        //
    }
}
