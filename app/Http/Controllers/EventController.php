<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

use Google\Client; 
use Google\Service\Calendar; 
use Illuminate\Support\Facades\Session;
use App\Http\Services\GoogleService;

class EventController extends Controller
{
    protected $calendar; 
    public function __construct(Client $client) { 
        $token = Session::get('google_token'); 
        if ($token) { 
            $client->setAccessToken($token); 
            $this->calendar = new Calendar($client); 
        } 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $googleService = new GoogleService(auth()->user());
        //dd($googleService->authUrl());
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
        $event = Event::create($request->all());

        /** Salva e sincroniza no Google Agenda */

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Evento cadastrado com sucesso!']);
    }


    public function update(Request $request, $id)
    {
        //dd($request);
        $event = Event::find($id);
        $event->update($request->all());
        /**Atualiza no google agenda */
        if ($this->calendar) { 
            $this->updateGoogleCalendarEvent($event); 
        }

        //return response()->json($event);
        return response()->json( ['success' => 'Evento alterado com sucesso!']);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        /**Exclui do google agenda */
        if ($this->calendar) { 
            $this->deleteGoogleCalendarEvent($event); 
        }

        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }


    /**Funções para google agenda */
    protected function createGoogleCalendarEvent($event)
    {
        try {
            $googleEvent = new \Google\Service\Calendar\Event([
                'summary' => $event->title,
                'description' => $event->description,
                'start' => [
                    'dateTime' => $event->start,
                    'timeZone' => 'America/Sao_Paulo',
                ],
                'end' => [
                    'dateTime' => $event->end,
                    'timeZone' => 'America/Sao_Paulo',
                ],
            ]);

            $calendarId = 'primary';
            $event = $this->calendar->events->insert($calendarId, $googleEvent);

            // Salvar o ID do evento do Google Calendar no banco de dados
            $event->google_event_id = $event->id;
            $event->save();
        } catch (\Exception $e) {
            \Log::error('Erro ao criar evento no Google Calendar: '.$e->getMessage());
        }
    }

    
    protected function updateGoogleCalendarEvent($event) { 
        $googleEvent = $this->calendar->events->get('primary', $event->google_event_id); 
        $googleEvent->setSummary($event->title); 
        $googleEvent->setStart(new \Google\Service\Calendar\EventDateTime(['dateTime' => $event->start_time])); 
        $googleEvent->setEnd(new \Google\Service\Calendar\EventDateTime(['dateTime' => $event->end_time])); 
        $this->calendar->events->update('primary', $googleEvent->getId(), $googleEvent); 
    } 
    
    protected function deleteGoogleCalendarEvent($event) { 
        $this->calendar->events->delete('primary', $event->google_event_id); 
    }






    
}/**Fim da classe do controller */
