<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;


class EventController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retorna Usuários do sistema
        $users = User::where('company_id', auth()->user()->company_id)
            ->orderBy('id', 'DESC')->get();

        // Carrega a view
        return view('events.index', [
            'users' => $users,
        ]);
    }

    public function fetchEvents()
    {
        // $events = Event::where('company_id', auth()->user()->company_id)
        // ->get();
        // return response()->json($events);
        $events = Event::where('events.company_id', auth()->user()->company_id)
            ->join('users', 'events.responsible_id', '=', 'users.id')
            ->select('events.*', 'users.name as responsible_name')
            ->get();

        return response()->json($events);
    }

    /**Cadastrar novo evento */
    public function store(Request $request)
    {
        // Cria o evento no banco de dados
        $event = Event::create($request->all());

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Evento cadastrado com sucesso!']);
    }


    /**Atualizar evento */
    public function update(Request $request, $id)
    {
        // Encontra o evento no banco de dados e atualiza
        $event = Event::find($id);
        $event->update($request->all());

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Evento alterado com sucesso!']);
    }

    /**Excluir evento */
    public function destroy($id)
    {
        // Encontra o evento no banco de dados
        $event = Event::find($id);
    
        // Exclui do banco de dados
        $event->delete();
    
        return response()->json(['message' => 'Evento excluído com sucesso!']);
    }
    


    /**Funções para google agenda */







    
}/**Fim da classe do controller */
