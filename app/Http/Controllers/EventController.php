<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Services\EventService;
use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Google_Service_Calendar_Event;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Google\Client as GoogleClient;
//use Google\Service\Calendar\Event;

class EventController extends Controller
{
    private $client; 
    public function __construct() { 
        $this->client = new GoogleClient(); 
        $this->client->setClientId(env('GOOGLE_CLIENT_ID')); 
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET')); 
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI')); 
        $this->client->addScope(Google_Service_Calendar::CALENDAR); 
    }
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
        /**Salva e sincroniza no google agenda */
        $this->syncGoogleCalendar($event, 'create');

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


    private function getClient() { 
        if (!$this->client->isAccessTokenExpired()) { 
            $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken()); 
        } 
        return $this->client; 
    } 
    
    private function syncGoogleCalendar($event, $action) { 
        $client = $this->getClient(); 
        $service = new Google_Service_Calendar($client); 
        switch ($action) { 
            case 'create': $googleEvent = new Google_Service_Calendar_Event([ 
                'summary' => $event->title, 
                'description' => $event->description, 
                'start' => ['dateTime' => $event->start_time], 
                'end' => ['dateTime' => $event->end_time], 
            ]); 
            $createdEvent = $service->events->insert('primary', $googleEvent); 
            $event->google_event_id = $createdEvent->id; 
            $event->save(); 
            break; 
            
            case 'update': 
                $googleEvent = $service->events->get('primary', $event->google_event_id); 
                $googleEvent->setSummary($event->title); 
                $googleEvent->setDescription($event->description); 
                $googleEvent->setStart(['dateTime' => $event->start_time]); 
                $googleEvent->setEnd(['dateTime' => $event->end_time]); 
                $updatedEvent = $service->events->update('primary', $googleEvent->getId(), $googleEvent); 
                break; 
                
            case 'delete': 
                $service->events->delete('primary', $event->google_event_id); 
                break; 
            } 
        }
}
