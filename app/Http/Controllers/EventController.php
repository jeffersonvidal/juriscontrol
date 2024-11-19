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
            \Log::info('Google Calendar initialized successfully');
        } else {
            \Log::error('Google token not found in session');
        }
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $googleService = new GoogleService(auth()->user());

        // Verifica se o token do Google está na sessão
        if (!Session::get('google_token')) {
            return redirect($googleService->authUrl());
        }

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

    public function store(Request $request)
    {
        // Cria o evento no banco de dados
        $event = Event::create($request->all());

        // Salva e sincroniza no Google Calendar, se possível
        if ($this->calendar) {
            \Log::info('Attempting to create Google Calendar event');
            $this->createGoogleCalendarEvent($event);
        } else {
            \Log::error('Google Calendar client not initialized');
        }

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Evento cadastrado com sucesso!']);
    }


    public function update(Request $request, $id)
    {
        // Encontra o evento no banco de dados e atualiza
        $event = Event::find($id);
        $event->update($request->all());

        // Atualiza no Google Calendar, se possível
        if ($this->calendar) {
            $this->updateGoogleCalendarEvent($event);
        }

        // Retorna uma resposta JSON com sucesso
        return response()->json(['success' => 'Evento alterado com sucesso!']);
    }

    public function destroy($id)
    {
        // Encontra o evento no banco de dados
        $event = Event::find($id);

        // Exclui do Google Calendar, se possível
        if ($this->calendar) {
            $this->deleteGoogleCalendarEvent($event);
        }

        // Exclui do banco de dados
        $event->delete();

        return response()->json(['message' => 'Evento excluído com sucesso!']);
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
            $googleEvent = $this->calendar->events->insert($calendarId, $googleEvent);

            // Salvar o ID do evento do Google Calendar no banco de dados
            $event->google_event_id = $googleEvent->id;
            $event->save();
        } catch (\Exception $e) {
            \Log::error('Erro ao criar evento no Google Calendar: '.$e->getMessage());
        }
    }

    
    protected function updateGoogleCalendarEvent($event)
    {
        try {
            $googleEvent = $this->calendar->events->get('primary', $event->google_event_id);

            $googleEvent->setSummary($event->title);
            $googleEvent->setDescription($event->description);
            $googleEvent->setStart(new \Google\Service\Calendar\EventDateTime(['dateTime' => $event->start, 'timeZone' => 'America/Sao_Paulo']));
            $googleEvent->setEnd(new \Google\Service\Calendar\EventDateTime(['dateTime' => $event->end, 'timeZone' => 'America/Sao_Paulo']));

            $this->calendar->events->update('primary', $googleEvent->getId(), $googleEvent);
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar evento no Google Calendar: '.$e->getMessage());
        }
    }
    
    protected function deleteGoogleCalendarEvent($event)
    {
        try {
            $this->calendar->events->delete('primary', $event->google_event_id);
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir evento no Google Calendar: '.$e->getMessage());
        }
    }

    /**
     * lógica para tratar o callback e salvar o token na sessão:*/
    public function handleGoogleCallback(Request $request)
{
    $googleService = new GoogleService(auth()->user());
    $client = $googleService->client;

    if ($request->input('code')) {
        $client->authenticate($request->input('code'));
        $token = $client->getAccessToken();
        Session::put('google_token', $token);
        \Log::info('Google token stored in session');
        
        return redirect()->route('events.index');
    } else {
        \Log::error('Google callback did not return an authorization code');
        return redirect()->route('events.index')->with('error', 'Failed to authenticate with Google Calendar');
    }
}








    
}/**Fim da classe do controller */
