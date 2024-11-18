<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
//use Google\Service\Calendar\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**Retorna Usuários do sistema */
        $users = User::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        /**Carrega vuew */
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

    public function store(Request $request)
    {
        //$request->is_all_day == true ? 1 : 0;

        //dd($request);
        $event = Event::create($request->all());
        //return response()->json($event);
        return response()->json( ['success' => 'Evento cadastrado com sucesso!']);
    }

    public function update(Request $request, $id)
    {
        //dd($request);
        $event = Event::find($id);
        $event->update($request->all());
        //return response()->json($event);
        return response()->json( ['success' => 'Evento alterado com sucesso!']);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
