<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\User;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Calendar\Event;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        //dd($request);
        //Validar o formulário
        $request->validated();

        /**Configuração no Google Drive */
        $client = new GoogleClient();
        $client->setClientId($company->gdrive_client_id);
        $client->setClientSecret($company->gdrive_client_secret);
        $client->refreshToken($company->gdrive_refresh_token);
        $client->setScopes(Google_Service_Calendar::CALENDAR);

        public function syncWithGoogleCalendar(Request $request)
        {
            $client = $this->getClient();

            if ($request->get('code')) {
                $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
                $client->setAccessToken($token);

                $service = new Google_Service_Calendar($client);

                // Obtenha eventos do banco de dados
                $events = Event::all();

                foreach ($events as $event) {
                    $googleEvent = new Google_Service_Calendar_Event([
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

                    $service->events->insert('primary', $googleEvent);
                }

                return response()->json(['message' => 'Eventos sincronizados com sucesso']);
            } else {
                return redirect($client->createAuthUrl());
            }
        }
        
        /**Salva no BD */
        $event = Event::create($request->all());
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return Event::find($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event)
    {
        $eventEdit = Event::findOrFail($event);
        $eventEdit->update($request->all());
        return response()->json($eventEdit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Event::destroy($event);
        return response()->json(['message' => 'Evento excluído com SUCESSO']);
    }
}
